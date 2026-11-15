<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_signed_in_user_can_review_a_book(): void
    {
        $user = User::factory()->create(['name' => 'Ada']);
        $other = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user)
            ->post(route('books.reviews.store', $book), [
                'body' => 'A wonderful read.',
                'user_id' => $other->id,
            ])
            ->assertRedirect(route('books.show', $book))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'body' => 'A wonderful read.',
        ]);
        $this->assertDatabaseCount('reviews', 1);

        $this->get(route('books.show', $book))
            ->assertSee('A wonderful read.')
            ->assertSee('Ada');
    }

    public function test_review_body_is_required(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user)
            ->post(route('books.reviews.store', $book), ['body' => ''])
            ->assertSessionHasErrors('body');

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_guests_cannot_review(): void
    {
        $book = Book::factory()->create();

        $this->post(route('books.reviews.store', $book), ['body' => 'Sneaky review'])
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('reviews', 0);
    }
}
