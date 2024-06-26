<?php

namespace Database\Seeders;

use App\Models\StudentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentStatus::create([
            'status' => 'действащ'
        ]);

        StudentStatus::create([
            'status' => 'прекъснал поради слаб успех'
        ]);

        StudentStatus::create([
            'status' => 'прекъснал по други причини'
        ]);

        StudentStatus::create([
            'status' => 'Абсолвент'
        ]);

        StudentStatus::create([
            'status' => 'Отчислен с право на защита'
        ]);

    }
}
