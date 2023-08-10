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
                'name' => 'CME Channel',
                'slug' => Str::slug('CME Channel')
            ],
            [
                'name' => 'CAS Channel',
                'slug' => Str::slug('CAS Channel')
            ],
            [
                'name' => 'COE Channel',
                'slug' => Str::slug('COE Channel')
            ],
        ]);
    }
}
