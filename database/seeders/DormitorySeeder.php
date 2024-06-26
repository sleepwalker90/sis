<?php

namespace Database\Seeders;

use App\Models\Dormitory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DormitorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dormitories = [
            '2', '3', '4',
            '4-Докт.', '12', '13', '14', '16', '33А', '54А', '54Б', '54В', '59А', '59Б', '59В', '59Г'
        ];
        foreach ($dormitories as $dormitory) {
            Dormitory::create([
                'building' => $dormitory
            ]);
        }
    }   
}
