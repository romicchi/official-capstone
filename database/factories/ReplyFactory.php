<?php

namespace Database\Factories;

use App\Models\Reply;
use App\Models\User;
use App\Models\Discussion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reply>
 */
class ReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content' => $this->faker->paragraph,
            'user_id' => User::factory(),
            'discussion_id' => Discussion::factory(),
        ];
    }
}
