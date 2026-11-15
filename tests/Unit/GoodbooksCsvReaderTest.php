<?php

namespace Tests\Unit;

use App\Support\Goodbooks\GoodbooksCsvReader;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class GoodbooksCsvReaderTest extends TestCase
{
    private function fixture(string $name): string
    {
        return dirname(__DIR__).'/fixtures/goodbooks/'.$name;
    }

    public function test_it_reads_and_normalises_books(): void
    {
        $books = iterator_to_array((new GoodbooksCsvReader)->books($this->fixture('books.csv')), false);

        $this->assertCount(4, $books, 'The row without a title is skipped.');

        $this->assertSame([
            'id' => 1,
            'title' => 'The Hunger Games (The Hunger Games, #1)',
            'authors' => 'Suzanne Collins',
            'isbn' => '0439023483',
            'original_publication_year' => 2008,
            'language_code' => 'eng',
            'image_url' => 'https://images.gr-assets.com/books/1447303603m/2767052.jpg',
        ], $books[0]);

        // Quoted fields with commas and apostrophes survive.
        $this->assertSame('J.K. Rowling, Mary GrandPré', $books[1]['authors']);
        $this->assertSame("Harry Potter and the Sorcerer's Stone (Harry Potter, #1)", $books[1]['title']);

        // ISBNs ending in X are kept, empty language codes become null.
        $this->assertSame('067978327X', $books[2]['isbn']);
        $this->assertNull($books[2]['language_code']);

        // Negative (BC) years are supported.
        $this->assertSame(-720, $books[3]['original_publication_year']);
    }

    public function test_it_reads_ratings_and_skips_invalid_rows(): void
    {
        $ratings = iterator_to_array((new GoodbooksCsvReader)->ratings($this->fixture('ratings.csv')), false);

        $this->assertSame([
            ['user_id' => 1, 'book_id' => 1, 'rating' => 5],
            ['user_id' => 1, 'book_id' => 2, 'rating' => 4],
            ['user_id' => 2, 'book_id' => 1, 'rating' => 3],
            ['user_id' => 2, 'book_id' => 999, 'rating' => 4],
            ['user_id' => 3, 'book_id' => 4, 'rating' => 2],
            ['user_id' => 3, 'book_id' => 1, 'rating' => 4],
            ['user_id' => 4, 'book_id' => 2, 'rating' => 5],
        ], $ratings);
    }

    public function test_it_stops_after_the_ratings_limit(): void
    {
        $ratings = iterator_to_array((new GoodbooksCsvReader)->ratings($this->fixture('ratings.csv'), 3), false);

        $this->assertCount(3, $ratings);
        $this->assertSame(['user_id' => 2, 'book_id' => 1, 'rating' => 3], $ratings[2]);
    }

    public function test_it_fails_clearly_for_a_missing_file(): void
    {
        $this->expectException(RuntimeException::class);

        iterator_to_array((new GoodbooksCsvReader)->books($this->fixture('missing.csv')));
    }
}
