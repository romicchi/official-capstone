<?php

namespace Database\Factories;

use App\Models\Discussion;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscussionFactory extends Factory
{
    protected $model = Discussion::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'slug' => $this->faker->slug,
            'channel_id' => $this->faker->randomNumber(),
            'course_id' => Course::factory(),
        ];
    }
}