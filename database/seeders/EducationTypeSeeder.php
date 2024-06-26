<?php

namespace Database\Seeders;

use App\Models\EducationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EducationType::create([
            'type' => 'редовно'
        ]);

        EducationType::create([
            'type' => 'задочно'
        ]);

        EducationType::create([
            'type' => 'дистанционно'
        ]);
    }
}
