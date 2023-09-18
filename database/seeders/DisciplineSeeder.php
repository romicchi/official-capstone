<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Discipline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisciplineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cas = College::where('collegeName', 'CAS')->first();

        Discipline::create([
            'college_id' => $cas->id,
            'disciplineName' => 'Computer Science',
        ]);

        Discipline::create([
            'college_id' => $cas->id,
            'disciplineName' => 'Mathematics',
        ]);

        Discipline::create([
            'college_id' => $cas->id,
            'disciplineName' => 'Natural Sciences',
        ]);

        Discipline::create([
            'college_id' => $cas->id,
            'disciplineName' => 'The Arts',
        ]);

        Discipline::create([
            'college_id' => $cas->id,
            'disciplineName' => 'Sports',
        ]);

        Discipline::create([
            'college_id' => $cas->id,
            'disciplineName' => 'Applied Sciences',
        ]);

        Discipline::create([
            'college_id' => $cas->id,
            'disciplineName' => 'Social Sciences',
        ]);

        $cme = College::where('collegeName', 'CME')->first();

        Discipline::create([
            'college_id' => $cme->id,
            'disciplineName' => 'Language',
        ]);

        Discipline::create([
            'college_id' => $cme->id,
            'disciplineName' => 'Linguistics',
        ]);

        Discipline::create([
            'college_id' => $cme->id,
            'disciplineName' => 'Literature',
        ]);

        Discipline::create([
            'college_id' => $cme->id,
            'disciplineName' => 'Geography',
        ]);

        Discipline::create([
            'college_id' => $cme->id,
            'disciplineName' => 'Management',
        ]);

        $coe = College::where('collegeName', 'COE')->first();

        Discipline::create([
            'college_id' => $coe->id,
            'disciplineName' => 'Philosophy',
        ]);

        Discipline::create([
            'college_id' => $coe->id,
            'disciplineName' => 'Psychology',
        ]);

        Discipline::create([
            'college_id' => $coe->id,
            'disciplineName' => 'History',
        ]);
    }
}