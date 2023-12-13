<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titel'=>$this->faker->title,
            'price'=>$this->faker->randomDigit(),
            'inventory'=>$this->faker->randomDigit(),
            'description'=>$this->faker->text,
        ];
    }
}
