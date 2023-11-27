<?php

namespace Database\Factories;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisciplineFactory extends Factory
{
    protected $model = Discipline::class;

    public function definition()
    {
        return [
            'college_id' => function() {
                return \App\Models\College::factory()->create()->id;
            },
            'disciplineName' => $this->faker->word,
        ];
    }
}