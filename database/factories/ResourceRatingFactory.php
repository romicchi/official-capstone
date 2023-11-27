<?php

namespace Database\Factories;

use App\Models\ResourceRating;
use App\Models\User;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceRatingFactory extends Factory
{
    protected $model = ResourceRating::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'resource_id' => Resource::factory()->create()->id,
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}