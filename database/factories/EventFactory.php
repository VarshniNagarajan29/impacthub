<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'organisation_id' => Organisation::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(2, true),
            'location' => fake()->address(),
            'starts_at' => fake()->dateTimeBetween('+1 day', '+3 months'),
            'capacity' => fake()->numberBetween(5, 50),
            'image_path' => null,
            'latitude' => fake()->randomFloat(7, -28, -27),
            'longitude' => fake()->randomFloat(7, 153, 154),
        ];
    }
}