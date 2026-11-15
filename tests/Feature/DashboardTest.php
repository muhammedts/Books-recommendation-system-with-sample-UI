<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_dashboard_shows_an_empty_state_without_recommendations(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('No recommendations yet.')
            ->assertSee('Spark ALS job');
    }

    public function test_dashboard_lists_recommendations_in_rank_order(): void
    {
        $user = User::factory()->create();
        $someoneElse = User::factory()->create();

        $third = Book::factory()->create(['title' => 'Third Pick']);
        $first = Book::factory()->create(['title' => 'First Pick']);
        $second = Book::factory()->create(['title' => 'Second Pick']);
        $notMine = Book::factory()->create(['title' => 'Somebody Else Pick']);

        // Rows as the Spark job writes them, deliberately out of order.
        Recommendation::factory()->for($user)->for($third)->create(['rank' => 3, 'score' => 3.9]);
        Recommendation::factory()->for($user)->for($first)->create(['rank' => 1, 'score' => 4.8]);
        Recommendation::factory()->for($user)->for($second)->create(['rank' => 2, 'score' => 4.2]);
        Recommendation::factory()->for($someoneElse)->for($notMine)->create(['rank' => 1, 'score' => 5.0]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSeeInOrder(['First Pick', 'Second Pick', 'Third Pick'])
            ->assertDontSee('Somebody Else Pick')
            ->assertDontSee('No recommendations yet.');
    }

    public function test_dashboard_lists_the_users_own_ratings(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['title' => 'Rated By Me']);
        $other = Book::factory()->create(['title' => 'Rated By Someone Else']);
        $book->rateBy($user, 4);
        $other->rateBy(User::factory()->create(), 2);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertSee('Rated By Me')
            ->assertDontSee('Rated By Someone Else');
    }
}
