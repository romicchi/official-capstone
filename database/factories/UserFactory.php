<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'year_level' => $this->faker->randomElement([1, 2, 3, 4]), // Example for year level
            'role_id' => 3, // Default role ID
            'student_number' => $this->faker->unique()->randomNumber(8),
            'url' => $this->faker->url,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'seen_guide' => 0,
            'remember_token' => Str::random(10),
            'college_id' => function() {
                return \App\Models\College::factory()->create()->id;
            },
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
