<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['key' => 'disable_registration', 'value' => 'false'],
            ['key' => 'scholarship_top_amount', 'value' => '170'],
            ['key' => 'scholarship_excelent_amount', 'value' => '150'],
        ]);

    }
}
