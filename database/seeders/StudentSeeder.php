<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Process\FakeProcessResult;
use Illuminate\Support\Testing\Fakes\Fake;
use Faker\Factory as Faker;
use App\Models\Group;
use Illuminate\Support\Facades\Log;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(2);
        $egn = $this->generateValidEGN();
        Student::create([
            'user_id' => $user->id,
            'student_status_id' => 1,
            'major_id' => 16,
            'tuition_id' => 1,
            'fn' => fake()->numberBetween(1000000, 9999999),
            'started_semester' => 4,
            'certified_semester' => 4,
            'study_plan_id' => 16,
            'egn' => $egn
        ]);
        $faker = Faker::create('bg_BG'); // Bulgarian locale
        $groups = Group::all();

        foreach ($groups as $group) {
            $academicYear = $group->academicYear->year;
            $yearPrefix = substr($academicYear, 0, 4);



            for ($i = 1; $i <= rand(25, 30); $i++) {
                $gender = $faker->randomElement(['male', 'female']);
                $firstName = $faker->firstName($gender);
                $middleName = $faker->lastName($gender);
                $lastName = $faker->lastName($gender);
                $egn = $this->generateValidEgn();

                // Generate fn number
                $fnPrefix = $group->stream->studyPlan->major->faculty_id . $group->stream->studyPlan->major->id . $yearPrefix;
                $existingStudents = Student::where('fn', 'like', "$fnPrefix%")->count();
                $fnNumber = $fnPrefix . str_pad($existingStudents + 1, 3, '0', STR_PAD_LEFT);

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

                $user->assignRole('Student');

                Student::create([
                    'user_id' => $user->id,
                    'fn' => $fnNumber,
                    'major_id' => $group->stream->studyPlan->major->id,
                    'started_semester' => 1,
                    'certified_semester' => 0,
                    'student_status_id' => 1, // Default status
                    'study_plan_id' => $group->stream->studyPlan->id,
                    'tuition_id' => 1, // Default tuition
                    'group_id' => $group->id,
                    'egn' => $egn,
                ]);
            }
        }
    }

    private function generateValidEgn()
    {
        // Generate a random date between 01.01.1998 and 31.12.2006
        $startDate = strtotime('1998-01-01');
        $endDate = strtotime('2006-12-31');
        $randomDate = mt_rand($startDate, $endDate);
        $year = date('Y', $randomDate);
        $month = date('m', $randomDate);
        $day = date('d', $randomDate);

        // Adjust month for different centuries
        if ($year >= 2000) {
            $adjustedYear = $year - 2000;
            $adjustedMonth = $month + 40;
        } elseif ($year >= 1900) {
            $adjustedYear = $year - 1900;
            $adjustedMonth = $month;
        } else {
            $adjustedYear = $year - 1800;
            $adjustedMonth = $month + 20;
        }

        // Ensure adjusted values are formatted correctly
        $egn = sprintf('%02d%02d%02d', $adjustedYear, $adjustedMonth, $day);

        // Add random digits for the next 3 positions
        for ($i = 0; $i < 3; $i++) {
            $egn .= mt_rand(0, 9);
        }


        // Calculate the checksum
        $weights = [2, 4, 8, 5, 10, 9, 7, 3, 6];
        $checksum = 0;
        for ($i = 0; $i < 9; $i++) {
            $checksum += intval($egn[$i]) * $weights[$i];
        }
        $checksum = $checksum % 11;
        $checksum = $checksum == 10 ? 0 : $checksum;

        // Append the checksum to the EGN
        $egn .= $checksum;

        return $egn;
    }
}
