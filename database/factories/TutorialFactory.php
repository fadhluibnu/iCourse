<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tutorial>
 */
class TutorialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->title(),
            'image' => 'http://image-api-icourse.000webhostapp.com/public_html/image/drhpvNU5HddQ72Z11scj9rSxzbghxlUN5rCUWGE2.png',
            'slug' => fake()->slug(),
            'description' => fake()->text(),
            'level' => 1
        ];
    }
}
