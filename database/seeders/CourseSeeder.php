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
        
        // CME
        Course::create([
            'college_id' => $cme->id,
            'courseName' => 'BSENTREP',
        ]);

        Course::create([
            'college_id' => $cme->id,
            'courseName' => 'BSSHAE',
        ]);

        Course::create([
            'college_id' => $cme->id,
            'courseName' => 'BSHM',
        ]);

        Course::create([
            'college_id' => $cme->id,
            'courseName' => 'BSHRM',
        ]);

        Course::create([
            'college_id' => $cme->id,
            'courseName' => 'BSTM',
        ]);


        // CAS
        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BA COMM',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BAEL',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BACOMM',
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
            'courseName' => 'BSIT',
        ]);

        Course::create([
            'college_id' => $cas->id,
            'courseName' => 'BSSW',
        ]);

        // COE
        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BECED',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BEED',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BPED',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BSED-ENG',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BSED-FIL',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BSED-MAPEH',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BSED-MATH',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BSED-PHYS SCI',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BSED-SCI',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BSED-SOC STUD',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BSED-VALED',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BSNED',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'BTLED',
        ]);

        Course::create([
            'college_id' => $coe->id,
            'courseName' => 'TCP',
        ]);

    }
}
