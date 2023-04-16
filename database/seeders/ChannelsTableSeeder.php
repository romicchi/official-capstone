<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Channel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('channels')->insert([
            [
                'name' => 'BSIT Channel',
                'slug' => Str::slug('BSIT Channel')
            ],
            [
                'name' => 'BACOMM Channel',
                'slug' => Str::slug('BACOMM Channel')
            ],
            [
                'name' => 'BEED Channel',
                'slug' => Str::slug('BEED Channel')
            ],
            [
                'name' => 'TM Channel',
                'slug' => Str::slug('TM Channel')
            ]
        ]);
    }
}
