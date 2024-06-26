<?php

namespace Database\Seeders;

use App\Models\Tuition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TuitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tuition::create([
            'name' => 'Държавна поръчка',
            'slug' => 'ДП'
        ]);

        Tuition::create([
            'name' => 'Платена поръчка',
            'slug' => 'ПП'
        ]);
    }
}
