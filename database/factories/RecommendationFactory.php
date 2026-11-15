<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recommendation>
 */
class RecommendationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'rank' => fake()->unique()->numberBetween(1, 50),
            'score' => fake()->randomFloat(4, 1, 5),
            'generated_at' => now(),
        ];
    }
}
