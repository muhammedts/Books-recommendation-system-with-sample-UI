<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrowseBooksTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_redirects_to_the_catalogue(): void
    {
        $this->get('/')->assertRedirect('/books');
    }

    public function test_guests_can_browse_books(): void
    {
        $book = Book::factory()->create(['title' => 'The Left Hand of Darkness']);

        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee('The Left Hand of Darkness')
            ->assertSee('images/slider1.jpg');

        $this->get(route('books.show', $book))
            ->assertOk()
            ->assertSee('The Left Hand of Darkness')
            ->assertSee('Log in</a> to rate', false);
    }

    public function test_search_filters_by_title_or_author_and_paginates(): void
    {
        Book::factory()->create(['title' => 'Dune', 'authors' => 'Frank Herbert']);
        Book::factory()->create(['title' => 'Children of Dune', 'authors' => 'Frank Herbert']);
        Book::factory()->create(['title' => 'Emma', 'authors' => 'Jane Austen']);
        Book::factory()->count(15)->create(['authors' => 'Ursula K. Le Guin']);

        $this->get(route('books.index', ['q' => 'dune']))
            ->assertOk()
            ->assertSee('Children of Dune')
            ->assertDontSee('Emma')
            ->assertDontSee('images/slider1.jpg')
            ->assertViewHas('books', fn ($books) => $books->total() === 2);

        $this->get(route('books.index', ['q' => 'austen']))
            ->assertSee('Emma')
            ->assertDontSee('Children of Dune');

        $this->get(route('books.index', ['q' => 'Le Guin']))
            ->assertViewHas('books', fn ($books) => $books->total() === 15 && $books->count() === 12);

        $this->get(route('books.index', ['q' => 'Le Guin', 'page' => 2]))
            ->assertViewHas('books', fn ($books) => $books->count() === 3);
    }

    public function test_most_rated_sidebar_lists_books_by_rating_count(): void
    {
        $popular = Book::factory()->create(['title' => 'Popular Book']);
        $popular->forceFill(['ratings_count' => 50, 'average_rating' => 4.1])->save();
        $quiet = Book::factory()->create(['title' => 'Quiet Book']);
        $quiet->forceFill(['ratings_count' => 2, 'average_rating' => 3.0])->save();
        Book::factory()->create(['title' => 'Unrated Book']);

        $this->get(route('books.index'))
            ->assertViewHas('mostRated', fn ($books) => $books->pluck('title')->all() === ['Popular Book', 'Quiet Book']);
    }

    public function test_cover_url_handles_remote_uploaded_and_missing_images(): void
    {
        $remote = Book::factory()->make(['image_url' => 'https://images.gr-assets.com/books/1m/1.jpg']);
        $uploaded = Book::factory()->make(['image_url' => 'covers/dune.jpg']);
        $missing = Book::factory()->make(['image_url' => null]);
        $noPhoto = Book::factory()->make(['image_url' => 'https://s.gr-assets.com/assets/nophoto/book/111x148.png']);

        $this->assertSame('https://images.gr-assets.com/books/1m/1.jpg', $remote->cover_url);
        $this->assertStringEndsWith('/storage/covers/dune.jpg', $uploaded->cover_url);
        $this->assertStringEndsWith('/images/no-cover.svg', $missing->cover_url);
        $this->assertStringEndsWith('/images/no-cover.svg', $noPhoto->cover_url);
    }
}
