<?php

namespace Database\Seeders;

use App\Models\DegreeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DegreeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DegreeType::create([
            'type' => 'Бакалавър'
        ]);

        DegreeType::create([
            'type' => 'Магистър'
        ]);

        DegreeType::create([
            'type' => 'Доктор'
        ]);
    }
}
