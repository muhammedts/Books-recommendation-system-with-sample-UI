<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportGoodbooksTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_imports_books_ratings_and_readers_from_local_files(): void
    {
        // A real account that must not be mixed up with dataset reader #1.
        $admin = User::factory()->admin()->create();

        $this->artisan('books:import', [
            '--books' => base_path('tests/fixtures/goodbooks/books.csv'),
            '--ratings' => base_path('tests/fixtures/goodbooks/ratings.csv'),
            '--chunk' => 2,
        ])->assertSuccessful();

        $this->assertSame(4, Book::count());
        $this->assertSame('0439023483', Book::find(1)->isbn);

        // Rating for unknown book 999 and the invalid rows are skipped.
        $this->assertDatabaseCount('ratings', 6);
        $this->assertSame(4, User::where('email', 'like', 'reader%@example.invalid')->count());
        $this->assertSame(0, $admin->ratings()->count());

        $hungerGames = Book::find(1);
        $this->assertSame(3, $hungerGames->ratings_count);
        $this->assertSame('4.00', $hungerGames->average_rating);

        // Running it again is idempotent.
        $this->artisan('books:import', [
            '--books' => base_path('tests/fixtures/goodbooks/books.csv'),
            '--ratings' => base_path('tests/fixtures/goodbooks/ratings.csv'),
        ])->assertSuccessful();

        $this->assertDatabaseCount('ratings', 6);
        $this->assertSame(5, User::count());
    }

    public function test_ratings_limit_is_respected(): void
    {
        $this->artisan('books:import', [
            '--books' => base_path('tests/fixtures/goodbooks/books.csv'),
            '--ratings' => base_path('tests/fixtures/goodbooks/ratings.csv'),
            '--ratings-limit' => 2,
        ])->assertSuccessful();

        $this->assertDatabaseCount('ratings', 2);
    }
}
