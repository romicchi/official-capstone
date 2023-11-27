<?php

namespace Database\Factories;

use App\Models\College;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollegeFactory extends Factory
{
    protected $model = College::class;

    public function definition()
    {
        return [
            'collegeName' => $this->faker->unique()->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}