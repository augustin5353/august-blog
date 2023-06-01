<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'title' => $this->faker->sentence(15, true),
            'content' => $this->faker->sentences(25, true),
            'category_id' => $this->faker->randomNumber(1, 6),
            'approved' => $this->faker->boolean()
        ];
    }
}
