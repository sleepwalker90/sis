<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lecturer;
use App\Models\StudyPlan;
use Faker\Factory as Faker;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('bg_BG'); // Bulgarian locale

        for ($i = 0; $i < 300; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $firstName = $faker->firstName($gender);
            $middleName = $faker->lastName($gender);
            $lastName = $faker->lastName($gender);

            do {
                $email = fake()->unique()->safeEmail;
            } while (User::where('email', $email)->exists());

            $user = User::create([
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'email' => $email,
                'phone_number' => $faker->phoneNumber,
                'password' => bcrypt('password'), // Default password
            ]);

            $user->assignRole('Teacher');

            $lecturer = Lecturer::create([
                'user_id' => $user->id,
                'phone_number' => $faker->phoneNumber,
                'room_number' => $faker->numberBetween(100, 500),
                'title' => $faker->randomElement(['Professor', 'Associate Professor', 'Assistant Professor']),
            ]);

            $courses = StudyPlan::where('major_id', 16)->first()->courses;
            // Attach random courses to the lecturer

            $lecturer->preferredCourses()->attach($courses->random(rand(1, 3))->pluck('id'));

        }
    }
}
