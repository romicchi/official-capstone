<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('resource_types')->insert([
            ['type' => 'E-books'],
            ['type' => 'Journal Article'],
            ['type' => 'Module'],
            ['type' => 'Web Article'],
            ['type' => 'Plain Document'],
            ['type' => 'Presentation'],
            ['type' => 'Table'],
            ['type' => 'Research'],
            ['type' => 'Infographic'],
            ['type' => 'Diagrams'],
            ['type' => 'Posters'],
            ['type' => 'Video Lectures/Tutorials'],
            ['type' => 'Documentaries'],
            ['type' => 'Presentations with Video'],
            ['type' => 'Animations'],
        ]);
    }
}