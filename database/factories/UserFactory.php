<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_name' => fake()->name(),
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'age' => fake()->numberBetween(18,100),
            'email' => fake()->unique()->safeEmail(),
            'gender'=>fake()->randomElement(['male','female']),
            'phone_number'=>fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'address'=>fake()->address(),
            'country'=>fake()->country(),
            'city'=>fake()->city(),
            'province'=>fake()->city(),
            'postal_code'=>fake()->numberBetween(45,677547),
         ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
