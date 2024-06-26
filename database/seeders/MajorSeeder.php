<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Major::create([
            'name' => 'Автоматика, информационна и управляваща техника',
            'faculty_id' => 1,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Автоматика, информационна и управляваща техника',
            'faculty_id' => 1,
            'degree_type_id' => 2,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Вградени системи за управление',
            'faculty_id' => 1,
            'degree_type_id' => 2,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Автоматизация на инженерния труд и системи',
            'faculty_id' => 1,
            'degree_type_id' => 3,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Eлектротехника (на английски език)',
            'faculty_id' => 2,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Електроенергетика и електрообзавеждане',
            'faculty_id' => 2,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Eлектротехника',
            'faculty_id' => 2,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Автомобилна електроника',
            'faculty_id' => 3,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Електроника',
            'faculty_id' => 3,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Електроника',
            'faculty_id' => 3,
            'degree_type_id' => 2,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Електронно инженерство (на английски език)',
            'faculty_id' => 3,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8

        ]);

        Major::create([
            'name' => 'Телекомуникации',
            'faculty_id' => 4,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Телекомуникационно инженерство (на английски език)',
            'faculty_id' => 4,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Информационни технологии в индустрията',
            'faculty_id' => 5,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Компютърни науки и инженерство',
            'faculty_id' => 5,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Компютърно и софтуерно инженерство',
            'faculty_id' => 5,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Индустриален мениджмънт',
            'faculty_id' => 6,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Мениджмънт и бизнес информационни системи',
            'faculty_id' => 6,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Публична администрация',
            'faculty_id' => 6,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);

        Major::create([
            'name' => 'Стопанско управление',
            'faculty_id' => 6,
            'degree_type_id' => 1,
            'education_type_id' => 1,
            'semesters' => 8
        ]);
    }
}
