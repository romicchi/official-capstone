<?php

namespace Database\Factories;

use App\Models\Journal;
use App\Models\User;
use App\Models\Discipline;
use App\Models\College;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalFactory extends Factory
{
    protected $model = Journal::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'user_id' => User::factory(),
            'college_id' => College::factory(),
            'discipline_id' => Discipline::factory(),
        ];
    }
}