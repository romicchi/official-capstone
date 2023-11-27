<?php

namespace Database\Factories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'topic' => $this->faker->word,
            'keywords' => $this->faker->words(3, true),
            'author' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'json_url' => $this->faker->url,
            'college_id' => function() {
                return \App\Models\College::factory()->create()->id;
            },
            'discipline_id' => function() {
                return \App\Models\Discipline::factory()->create()->id;
            },
            'download_count' => $this->faker->numberBetween(0, 100),
            'view_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}