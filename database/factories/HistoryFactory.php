<?php

namespace Database\Factories;

use App\Models\History;
use App\Models\User;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryFactory extends Factory
{
    protected $model = History::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'resource_id' => Resource::factory()->create()->id,
        ];
    }
}