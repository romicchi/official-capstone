<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Course;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bsit = Course::where('subjectName', 'BSIT')->first();

        Subject::create([
            'course_id' => $bsit->id,
            'subjectName' => 'Quantitative Methods and Simulation',
        ]);
    
        Subject::create([
            'course_id' => $bsit->id,
            'subjectName' => 'Arduino II',
        ]);
    
        // Add more subjects and associate them with the appropriate course
        Subject::create([
            'course_id' => $bsit->id,
            'subjectName' => 'Information Assurance and Security',
        ]);
    }
}
