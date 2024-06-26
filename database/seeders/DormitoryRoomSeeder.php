<?php

namespace Database\Seeders;

use App\Models\Dormitory;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DormitoryRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dormitories = Dormitory::all();

        foreach ($dormitories as $dormitory) {
            $number_of_rooms = rand(15, 30);
            $floors = rand(3, 7);
            $beds = rand(2, 3);
    
            for($floor = 1; $floor <= $floors; $floor++) {
                for($room = 1; $room <= $number_of_rooms; $room++) {
                    Room::create([
                        'dormitory_id' => $dormitory->id,
                        'room_number' => $room < 10 ? $floor.'0'.$room : $floor.$room,
                        'beds' => $beds,
                        'occupied_beds' => rand(0, $beds),
                    ]);
                }
            }
        }
    }
        

}
