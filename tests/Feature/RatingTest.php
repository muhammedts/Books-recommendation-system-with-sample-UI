<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_rate_books(): void
    {
        $book = Book::factory()->create();

        $this->post(route('books.rating.store', $book), ['rating' => 5])
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('ratings', 0);
    }

    public function test_rating_is_stored_for_the_signed_in_user_even_if_another_user_id_is_posted(): void
    {
        $user = User::factory()->create();
        $victim = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user)
            ->post(route('books.rating.store', $book), [
                'rating' => 4,
                'user_id' => $victim->id,
                'book_id' => 999,
            ])
            ->assertRedirect(route('books.show', $book))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('ratings', ['user_id' => $user->id, 'book_id' => $book->id, 'rating' => 4]);
        $this->assertDatabaseMissing('ratings', ['user_id' => $victim->id]);
        $this->assertDatabaseCount('ratings', 1);
    }

    public function test_rerating_updates_the_existing_row_and_the_aggregates(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        Rating::factory()->for($book)->create(['rating' => 2]);
        Rating::factory()->for($book)->create(['rating' => 3]);
        Book::recalculateRatingStats();

        $this->actingAs($user)->post(route('books.rating.store', $book), ['rating' => 5]);

        $book->refresh();
        $this->assertSame(3, $book->ratings_count);
        $this->assertSame('3.33', $book->average_rating);

        $this->actingAs($user)->post(route('books.rating.store', $book), ['rating' => 1]);

        $this->assertSame(1, Rating::where('user_id', $user->id)->where('book_id', $book->id)->count());
        $this->assertDatabaseHas('ratings', ['user_id' => $user->id, 'book_id' => $book->id, 'rating' => 1]);

        $book->refresh();
        $this->assertSame(3, $book->ratings_count);
        $this->assertSame('2.00', $book->average_rating);
        $this->assertSame([5 => 0, 4 => 0, 3 => 1, 2 => 1, 1 => 1], $book->ratingBreakdown());
    }

    public function test_rating_must_be_between_one_and_five(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        foreach ([0, 6, 'abc', null] as $invalid) {
            $this->actingAs($user)
                ->post(route('books.rating.store', $book), ['rating' => $invalid])
                ->assertSessionHasErrors('rating');
        }

        $this->assertDatabaseCount('ratings', 0);
    }

    public function test_book_page_shows_the_users_current_rating(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $book->rateBy($user, 3);

        $this->actingAs($user)
            ->get(route('books.show', $book))
            ->assertOk()
            ->assertViewHas('userRating', 3)
            ->assertSee('Update rating');
    }
}
