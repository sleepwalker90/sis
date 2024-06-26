<?php

namespace Database\Seeders;

use App\Models\Course;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Първи семестър
        Course::create([
            'name' => 'Математика I',
            'hasLectures' => true,
            'hasSeminars' => true,
            'hasExam' => true,
            'code' => 'MAT13',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Физика',
            'hasLectures' => true,
            'hasSeminars' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'PHY03',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Въведение в програмирането',
            'hasLectures' => true,
            'hasSeminars' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'CCE01',
            'credits' => 7,
        ]);

        Course::create([
            'name' => 'Основи на инженерното програмиране',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'ENG04',
            'credits' => 4,
        ]);

        Course::create([
            'name' => 'Чужд език I',
            'hasSeminars' => true,
            'hasOa' => true,
            'code' => 'LNG11',
            'credits' => 3,
        ]);

        Course::create([
            'name' => 'Спорт',
            'code' => 'SPR01',
            'credits' => 1,
            'hasOa' => true,

        ]);
        // Втори семестър
        Course::create([
            'name' => 'Математика II',
            'hasLectures' => true,
            'hasSeminars' => true,
            'hasExam' => true,
            'code' => 'MAT22',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Материалознание',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'ENG05',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Базови програмни езици',
            'hasLectures' => true,
            'hasSeminars' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'CCE02',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Електротехника',
            'hasLectures' => true,
            'hasSeminars' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'EEA24',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Чужд език II',
            'hasSeminars' => true,
            'hasOa' => true,
            'code' => 'LNG12',
            'credits' => 3,
        ]);

        Course::create([
            'name' => 'Практикум',
            'hasOa' => true,
            'code' => 'PRC01',
            'credits' => 2,
        ]);


        Course::create([
            'name' => 'Спорт',
            'hasOa' => true,
            'code' => 'SPR02',
            'credits' => 1,
        ]);

        // Трети семестър
        Course::create([
            'name' => 'Математика III',
            'hasLectures' => true,
            'hasSeminars' => true,
            'hasExam' => true,
            'code' => 'MAT33',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Полупроводникови елементи',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'EEA25',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Механични системи',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'MEC24',
            'credits' => 4,
        ]);

        Course::create([
            'name' => 'Платформено-независими програмни езици',
            'hasLectures' => true,
            'hasSeminars' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'CCE03',
            'credits' => 7,
        ]);

        Course::create([
            'name' => 'Синтез и анализ на алгоритми',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'hasCw' => true,
            'code' => 'CCE04',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Спорт',
            'hasOa' => true,
            'code' => 'SPR03',
            'credits' => 1,
        ]);

        // Четвърти семестър
        Course::create([
            'name' => 'Компютърни системи',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'CCE05',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Сигнали и системи',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'CCE06',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Основи на мрежовите технологии',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'CCE07',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Бази данни',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'CCE08',
            'credits' => 6,
        ]);

        Course::create([
            'name' => 'Измервания в информационните и комуникационните технологии',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'EEA26',
            'credits' => 4,
        ]);

        Course::create([
            'name' => 'Бази данни - проект',
            'hasCp' => true,
            'code' => 'CCE09',
            'credits' => 2,
        ]);

        Course::create([
            'name' => 'Практикум',
            'hasOa' => true,
            'code' => 'PRC02',
            'credits' => 2,
        ]);


        Course::create([
            'name' => 'Спорт',
            'hasOa' => true,
            'code' => 'SPR04',
            'credits' => 1,
        ]);

        // Пети семестър
        Course::create([
            'name' => 'Анализ и синтез на логически схеми',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'BCSE01',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Компютърни архитектури',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'BCSE02',
            'credits' => 5,

        ]);

        Course::create([
            'name' => 'Компютърна периферия',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'BCSE03',
            'credits' => 4,
        ]);

        Course::create([
            'name' => 'Операционни системи',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'BCSE04',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Програмни езици',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'BCSE05',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Цифрова схемотехника',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'BCSE06',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Проект по дисциплина',
            'hasCp' => true,
            'code' => 'BCSE07',
            'credits' => 2,
        ]);

        // Шести семестър
        Course::create([
            'name' => 'Програмиране за мобилни устройства',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'BCSE08',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Програмни среди',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'BCSE09',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Високопроизводителни компютърни системи',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'BCSE10',
            'credits' => 4,
        ]);

        Course::create([
            'name' => 'Избираема дисциплина',
            'hasLectures' => true,
            'hasSeminars' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'code' => 'BCSE11',
            'credits' => 5,
            'is_elective_group' => true,
        ]);

        Course::create([
            'name' => 'Избираема дисциплина',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'BCSE12',
            'credits' => 4,
            'is_elective_group' => true,
        ]);

        Course::create([
            'name' => 'Избираема дисциплина',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'code' => 'BCSE13',
            'credits' => 5,
            'is_elective_group' => true,
        ]);

        Course::create([
            'name' => 'Проект по дисциплина',
            'hasCp' => true,
            'code' => 'BCSE14',
            'credits' => 2,
            'is_elective_group' => true,
        ]);

        // Седми семестър
        Course::create([
            'name' => 'Паралелно програмиране',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasExam' => true,
            'hasCw' => true,
            'code' => 'BCSE15',
            'credits' => 5,
        ]);

        Course::create([
            'name' => 'Компютърна графика',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'hasCw' => true,
            'code' => 'BCSE16',
            'credits' => 5,
        ]);

        // Осми семестър
        Course::create([
            'name' => 'Нерелационни бази данни',
            'hasLectures' => true,
            'hasLabs' => true,
            'hasOa' => true,
            'hasCw' => true,
            'code' => 'BCSE26',
            'credits' => 4,
        ]);
    }
}
