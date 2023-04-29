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
            'subjectName' => 'BSIT',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'subjectName' => 'BACOMM',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'subjectName' => 'BAEL',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'subjectName' => 'BAPOS',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'subjectName' => 'BLIS',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'subjectName' => 'BMME',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'subjectName' => 'BSBIO',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'subjectName' => 'BSSW',
        ]);

        

        // Add more courses and associate them with the appropriate college
    }
}
