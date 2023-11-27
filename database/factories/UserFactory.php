<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'year_level' => $this->faker->numberBetween(1, 4),
            'role_id' => function() {
                return \App\Models\Role::factory()->create()->id;
            },
            'student_number' => $this->faker->unique()->numerify('#########'),
            'url' => $this->faker->url,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'seen_guide' => $this->faker->boolean,
            'remember_token' => Str::random(10),
            'last_activity' => now(),
            'verified' => $this->faker->boolean,
            'archived' => $this->faker->boolean,
            'expiration_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'college_id' => function() {
                return \App\Models\College::factory()->create()->id;
            },
        ];
    }
}