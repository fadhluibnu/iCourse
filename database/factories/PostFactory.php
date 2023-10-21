<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author' => User::factory(),
            'title' => fake()->title(),
            'meta_desc' => fake()->text(100),
            'slug' => fake()->slug(),
            'tag' => '#programming',
            'category' => Category::factory(),
            'id_tutorial' => Tutorial::factory(),
            'tutorial_order' => 1,
            'cover' => 'http://image-api-icourse.000webhostapp.com/public_html/image/drhpvNU5HddQ72Z11scj9rSxzbghxlUN5rCUWGE2.png',
            'body' => fake()->text()
        ];
    }
}
