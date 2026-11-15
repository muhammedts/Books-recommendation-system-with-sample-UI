<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Rating;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Local demo data. The accounts below use the password "password" and are
 * meant for local development only; never run this seeder in production.
 * Import the real catalogue with `php artisan books:import`.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $demo = User::factory()->create([
            'name' => 'Demo Reader',
            'email' => 'demo@example.com',
        ]);

        $readers = User::factory()->count(15)->create();
        $books = Book::factory()->count(30)->create();

        // Every reader rates a random handful of books; the demo user rates a few too.
        foreach ($readers->push($demo) as $reader) {
            foreach ($books->random(fake()->numberBetween(4, 12)) as $book) {
                Rating::factory()->for($reader)->for($book)->create();
            }
        }

        foreach ($books->random(10) as $book) {
            Review::factory()->for($readers->random())->for($book)->create();
        }

        Book::recalculateRatingStats();

        $this->command?->info("Seeded {$books->count()} books. Log in as {$admin->email} (admin) or {$demo->email}, password \"password\".");
    }
}
