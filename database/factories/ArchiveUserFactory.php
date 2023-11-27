<?php

namespace Database\Factories;

use App\Models\ArchiveUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArchiveUserFactory extends Factory
{
    protected $model = ArchiveUser::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'role_id' => function() {
                return \App\Models\Role::factory()->create()->id;
            },
            'url' => $this->faker->url,
            'user_id' => $this->faker->randomDigitNotNull,
            'year_level' => $this->faker->randomDigitNotNull,
            'archived_at' => now(),
            'college_id' => function() {
                return \App\Models\College::factory()->create()->id;
            },
        ];
    }
}