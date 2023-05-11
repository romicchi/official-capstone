<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\College;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cme = College::where('collegeName', 'CME')->first();
        $cas = College::where('collegeName', 'CAS')->first();
        $coe = College::where('collegeName', 'COE')->first();
        

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BSIT',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BACOMM',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BAEL',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BAPOS',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BLIS',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BMME',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BSBIO',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BSSW',
        ]);

    }
}
