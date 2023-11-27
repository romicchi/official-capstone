<?php

namespace Database\Factories;

use App\Models\Reply;
use App\Models\User;
use App\Models\Discussion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyFactory extends Factory
{
    protected $model = Reply::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'discussion_id' => Discussion::factory(),
            'content' => $this->faker->paragraph,
        ];
    }
}