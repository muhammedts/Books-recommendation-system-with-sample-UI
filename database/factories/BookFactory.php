<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => rtrim(fake()->unique()->sentence(fake()->numberBetween(2, 5)), '.'),
            'authors' => fake()->name(),
            'isbn' => fake()->isbn10(),
            'original_publication_year' => fake()->numberBetween(1850, 2024),
            'language_code' => fake()->randomElement(['eng', 'en-US', 'en-GB', 'fre', 'spa']),
            'image_url' => null,
        ];
    }
}
