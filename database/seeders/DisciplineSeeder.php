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
            'discipline_id' => $cas->id,
            'discipline_Name' => 'Computer Science',
        ]);

        Discipline::create([
            'discipline_id' => $cas->id,
            'discipline_Name' => 'Mathematics',
        ]);

        Discipline::create([
            'discipline_id' => $cas->id,
            'discipline_Name' => 'Natural Sciences',
        ]);

        Discipline::create([
            'discipline_id' => $cas->id,
            'discipline_Name' => 'The Arts',
        ]);

        Discipline::create([
            'discipline_id' => $cas->id,
            'discipline_Name' => 'Sports',
        ]);

        Discipline::create([
            'discipline_id' => $cas->id,
            'discipline_Name' => 'Applied Sciences',
        ]);

        Discipline::create([
            'discipline_id' => $cas->id,
            'discipline_Name' => 'Social Sciences',
        ]);

        $cme = College::where('collegeName', 'CME')->first();

        Discipline::create([
            'discipline_id' => $cme->id,
            'discipline_Name' => 'Language',
        ]);

        Discipline::create([
            'discipline_id' => $cme->id,
            'discipline_Name' => 'Linguistics',
        ]);

        Discipline::create([
            'discipline_id' => $cme->id,
            'discipline_Name' => 'Literature',
        ]);

        Discipline::create([
            'discipline_id' => $cme->id,
            'discipline_Name' => 'Geography',
        ]);

        Discipline::create([
            'discipline_id' => $cme->id,
            'discipline_Name' => 'Management',
        ]);

        $coe = College::where('collegeName', 'COE')->first();

        Discipline::create([
            'discipline_id' => $coe->id,
            'discipline_Name' => 'Philosophy',
        ]);

        Discipline::create([
            'discipline_id' => $coe->id,
            'discipline_Name' => 'Psychology',
        ]);

        Discipline::create([
            'discipline_id' => $coe->id,
            'discipline_Name' => 'History',
        ]);
    }
}