<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Support\Goodbooks\GoodbooksCsvReader;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class ImportGoodbooks extends Command
{
    public const BOOKS_URL = 'https://raw.githubusercontent.com/zygmuntz/goodbooks-10k/master/books.csv';

    public const RATINGS_URL = 'https://raw.githubusercontent.com/zygmuntz/goodbooks-10k/master/ratings.csv';

    protected $signature = 'books:import
        {--books= : Path or URL of books.csv (default: the goodbooks-10k copy on GitHub)}
        {--ratings= : Path or URL of ratings.csv (default: the goodbooks-10k copy on GitHub)}
        {--ratings-limit=100000 : Maximum number of ratings to import, 0 for all (about 6 million)}
        {--chunk=1000 : Rows per bulk insert}
        {--skip-ratings : Import books only}';

    protected $description = 'Import books, ratings and placeholder readers from the goodbooks-10k dataset';

    /** Dataset user id => users.id */
    private array $readerIds = [];

    private string $readerPassword;

    public function handle(GoodbooksCsvReader $reader): int
    {
        $chunk = max(1, (int) $this->option('chunk'));
        $limit = (int) $this->option('ratings-limit');

        try {
            $books = $this->importBooks($reader, $this->option('books') ?: self::BOOKS_URL, $chunk);

            if ($this->option('skip-ratings')) {
                $ratings = 0;
            } else {
                $ratings = $this->importRatings(
                    $reader,
                    $this->option('ratings') ?: self::RATINGS_URL,
                    $limit > 0 ? $limit : null,
                    $chunk,
                );
            }
        } catch (Throwable $e) {
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }

        $this->components->task('Recalculating book rating aggregates', fn () => Book::recalculateRatingStats());

        $this->components->info(sprintf(
            'Imported %s books, %s ratings and %s readers.',
            number_format($books),
            number_format($ratings),
            number_format(count($this->readerIds)),
        ));

        return self::SUCCESS;
    }

    private function importBooks(GoodbooksCsvReader $reader, string $source, int $chunk): int
    {
        $this->components->info("Importing books from {$source}");

        $now = now();
        $total = 0;

        foreach ($this->chunked($reader->books($source), $chunk) as $rows) {
            $rows = array_map(fn ($row) => $row + ['created_at' => $now, 'updated_at' => $now], $rows);

            DB::table('books')->upsert(
                $rows,
                ['id'],
                ['title', 'authors', 'isbn', 'original_publication_year', 'language_code', 'image_url', 'updated_at'],
            );

            $total += count($rows);
            $this->output->write("\r  {$total} books");
        }

        $this->newLine();

        return $total;
    }

    private function importRatings(GoodbooksCsvReader $reader, string $source, ?int $limit, int $chunk): int
    {
        $this->components->info("Importing ratings from {$source}".($limit ? " (first {$limit})" : ''));

        // Placeholder readers can never log in: they share one hash of a random secret.
        $this->readerPassword = Hash::make(Str::random(64));

        $bookIds = array_flip(DB::table('books')->pluck('id')->all());
        $total = 0;

        foreach ($this->chunked($reader->ratings($source, $limit), $chunk) as $rows) {
            // Drop ratings for unknown books and keep the last rating per (user, book).
            $unique = [];
            foreach ($rows as $row) {
                if (isset($bookIds[$row['book_id']])) {
                    $unique[$row['user_id'].':'.$row['book_id']] = $row;
                }
            }
            $rows = array_values($unique);

            if ($rows === []) {
                continue;
            }

            DB::transaction(function () use ($rows) {
                $this->ensureReaders(array_unique(array_column($rows, 'user_id')));

                $now = now();

                DB::table('ratings')->upsert(
                    array_map(fn ($row) => [
                        'user_id' => $this->readerIds[$row['user_id']],
                        'book_id' => $row['book_id'],
                        'rating' => $row['rating'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ], $rows),
                    ['user_id', 'book_id'],
                    ['rating', 'updated_at'],
                );
            });

            $total += count($rows);
            $this->output->write("\r  {$total} ratings");
        }

        $this->newLine();

        return $total;
    }

    /**
     * Create users for dataset reader ids we have not seen yet. Readers get
     * their own auto-increment id (so they never collide with real accounts)
     * and are matched by their reader{id}@example.invalid email.
     *
     * @param  array<int>  $datasetUserIds
     */
    private function ensureReaders(array $datasetUserIds): void
    {
        $missing = array_values(array_filter($datasetUserIds, fn ($id) => ! isset($this->readerIds[$id])));

        if ($missing === []) {
            return;
        }

        $now = now();
        $emails = [];

        foreach ($missing as $id) {
            $emails[$id] = "reader{$id}@example.invalid";
        }

        DB::table('users')->insertOrIgnore(array_map(fn ($id) => [
            'name' => "Reader {$id}",
            'email' => $emails[$id],
            'password' => $this->readerPassword,
            'is_admin' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ], $missing));

        $idsByEmail = DB::table('users')->whereIn('email', array_values($emails))->pluck('id', 'email');

        foreach ($emails as $datasetId => $email) {
            $this->readerIds[$datasetId] = $idsByEmail[$email];
        }
    }

    /**
     * @template T
     *
     * @param  iterable<T>  $items
     * @return \Generator<int, array<int, T>>
     */
    private function chunked(iterable $items, int $size): \Generator
    {
        $buffer = [];

        foreach ($items as $item) {
            $buffer[] = $item;

            if (count($buffer) >= $size) {
                yield $buffer;
                $buffer = [];
            }
        }

        if ($buffer !== []) {
            yield $buffer;
        }
    }
}
