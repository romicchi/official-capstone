<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => function() {
                return \App\Models\User::factory()->create()->id;
            },
            'resource_id' => function() {
                return \App\Models\Resource::factory()->create()->id;
            },
            'comment_text' => $this->faker->sentence,
        ];
    }
}