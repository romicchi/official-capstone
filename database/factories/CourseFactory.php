<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\College;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'college_id' => function() {
                return \App\Models\College::factory()->create()->id;
            },
            'courseName' => $this->faker->unique()->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}