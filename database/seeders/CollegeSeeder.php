<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\College;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        College::create(['collegeName' => 'CME']);
        College::create(['collegeName' => 'CAS']);
        College::create(['collegeName' => 'COE']);
    }
}
