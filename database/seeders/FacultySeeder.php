<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faculty::create([
            'name' => 'Факултет Автоматика'
        ]);

        Faculty::create([
            'name' => 'Електротехнически факултет'
        ]);

        Faculty::create([
            'name' => 'Факултет електронна техника и технологии'
        ]);

        Faculty::create([
            'name' => 'Факултет по телекомуникации'
        ]);

        Faculty::create([
            'name' => 'Факултет Компютърни системи и технологии'
        ]);

        Faculty::create([
            'name' => 'Стопански факултет'
        ]);
    }
}
