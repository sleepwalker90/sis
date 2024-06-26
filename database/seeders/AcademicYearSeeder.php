<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = now()->year;

        for ($startYear = $year - 6; $startYear <= $year; $startYear++) {
            AcademicYear::create([
                'year' => $startYear . '/' . ($startYear + 1),
            ]);
        }
    }
}
