<?php

namespace Database\Factories;

use App\Models\Discipline;
use App\Models\College;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisciplineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discipline::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'disciplineName' => $this->faker->sentence,
            'college_id' => College::factory(),
        ];
    }
}