<?php

namespace App\Support\Goodbooks;

use Generator;
use RuntimeException;

/**
 * Streams rows from the goodbooks-10k CSV files
 * (https://github.com/zygmuntz/goodbooks-10k) and normalises them into
 * arrays that match the books and ratings tables.
 *
 * Sources can be local paths or URLs; files are read line by line so the
 * 70 MB ratings.csv never has to fit in memory.
 */
class GoodbooksCsvReader
{
    /**
     * @return Generator<int, array{id: int, title: string, authors: string, isbn: ?string, original_publication_year: ?int, language_code: ?string, image_url: ?string}>
     */
    public function books(string $source): Generator
    {
        foreach ($this->records($source) as $record) {
            // The current CSV has book_id (1..10000, used by ratings.csv) next to
            // goodreads_book_id; older copies named that column "id" instead.
            $id = (int) (array_key_exists('goodreads_book_id', $record)
                ? $record['book_id']
                : ($record['id'] ?? $record['book_id'] ?? 0));

            $title = $this->clean($record['title'] ?? null) ?? $this->clean($record['original_title'] ?? null);

            if ($id < 1 || $title === null) {
                continue;
            }

            yield [
                'id' => $id,
                'title' => mb_substr($title, 0, 500),
                'authors' => mb_substr($this->clean($record['authors'] ?? null) ?? 'Unknown', 0, 1000),
                'isbn' => $this->isbn($record['isbn'] ?? null),
                'original_publication_year' => $this->year($record['original_publication_year'] ?? null),
                'language_code' => $this->limit($this->clean($record['language_code'] ?? null), 16),
                'image_url' => $this->limit($this->clean($record['image_url'] ?? null), 255),
            ];
        }
    }

    /**
     * @return Generator<int, array{user_id: int, book_id: int, rating: int}>
     */
    public function ratings(string $source, ?int $limit = null): Generator
    {
        $count = 0;

        foreach ($this->records($source) as $record) {
            if ($limit !== null && $count >= $limit) {
                return;
            }

            $userId = (int) ($record['user_id'] ?? 0);
            $bookId = (int) ($record['book_id'] ?? 0);
            $rating = (int) ($record['rating'] ?? 0);

            if ($userId < 1 || $bookId < 1 || $rating < 1 || $rating > 5) {
                continue;
            }

            $count++;

            yield ['user_id' => $userId, 'book_id' => $bookId, 'rating' => $rating];
        }
    }

    /**
     * @return Generator<int, array<string, string|null>>
     */
    private function records(string $source): Generator
    {
        $error = null;
        set_error_handler(function (int $level, string $message) use (&$error) {
            $error = $message;

            return true;
        });

        try {
            $handle = fopen($source, 'rb');
        } finally {
            restore_error_handler();
        }

        if ($handle === false) {
            throw new RuntimeException("Unable to open [{$source}]".($error ? ": {$error}" : '.'));
        }

        try {
            $header = $this->read($handle);

            if ($header === null) {
                return;
            }

            $header = array_map(
                fn ($column) => strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $column))),
                $header,
            );
            $columns = count($header);

            while (($row = $this->read($handle)) !== null) {
                if ($row === [null] || count($row) !== $columns) {
                    continue;
                }

                yield array_combine($header, $row);
            }
        } finally {
            fclose($handle);
        }
    }

    /**
     * @param  resource  $handle
     * @return array<int, string|null>|null
     */
    private function read($handle): ?array
    {
        $row = fgetcsv($handle, null, ',', '"', '');

        return $row === false ? null : $row;
    }

    private function clean(?string $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function limit(?string $value, int $length): ?string
    {
        return $value !== null && mb_strlen($value) <= $length ? $value : null;
    }

    /**
     * ISBN-10s lose their leading zeros in the published CSV ("439023483"),
     * so digit-only values are padded back to ten characters.
     */
    private function isbn(?string $value): ?string
    {
        $value = $this->clean($value);

        if ($value === null || ! preg_match('/^[0-9]{1,9}[0-9Xx]$/', $value)) {
            return null;
        }

        return strtoupper(str_pad($value, 10, '0', STR_PAD_LEFT));
    }

    /**
     * Years are stored as floats ("1997.0") and can be negative (BC).
     */
    private function year(?string $value): ?int
    {
        $value = $this->clean($value);

        if ($value === null || ! is_numeric($value)) {
            return null;
        }

        $year = (int) round((float) $value);

        return $year >= -32768 && $year <= 32767 ? $year : null;
    }
}
