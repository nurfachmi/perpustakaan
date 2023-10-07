<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isbn' => fake()->isbn10(),
            'title' => str(fake('id_ID')->words(fake()->randomDigitNot(0), true))->title(),
            'author' => fake('id_ID')->name(),
            'publish_year' => fake()->year(),
            'description' => fake('id_ID')->paragraph(2),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id
        ];
    }
}
