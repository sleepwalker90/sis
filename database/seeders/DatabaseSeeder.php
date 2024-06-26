<?php

namespace Database\Seeders;

use App\Models\CourseLecturerAssignment;
use App\Models\Lecturer;
use App\Models\Mark;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $student = Role::create(['name' => 'Student']);
        $teacher = Role::create(['name' => 'Teacher']);
        $admin = Role::create(['name' => 'Admin']);

        $perms = [
            'create_course' => Permission::create(['name' => 'create_course']),
            'view_course' => Permission::create(['name' => 'view_course']),
            'edit_course' => Permission::create(['name' => 'edit_course']),
            'delete_course' => Permission::create(['name' => 'delete_course']),
        ];

        $admin->permissions()->sync([
            $perms['create_course']->id,
            $perms['view_course']->id,
            $perms['edit_course']->id,
            $perms['delete_course']->id
        ]);

        $teacher->permissions()->sync([
            $perms['create_course']->id,
            $perms['view_course']->id,
            $perms['edit_course']->id
        ]);

        $student->permissions()->sync([
            $perms['view_course']->id
        ]);

        $faker = \Faker\Factory::create('bg_BG');
        $gender = $faker->randomElement(['male', 'female']);

        $adminUser = User::create([
            'first_name' => $faker->firstName($gender),
            'middle_name' => $faker->lastName($gender),
            'last_name' => $faker->lastName($gender),
            'phone_number' => $faker->phoneNumber(),
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);

        $gender = $faker->randomElement(['male', 'female']);

        $studentUser = User::create([
            'first_name' => $faker->firstName($gender),
            'middle_name' => $faker->lastName($gender),
            'last_name' => $faker->lastName($gender),
            'phone_number' => $faker->phoneNumber(),
            'email' => 'student@student.com',
            'password' => bcrypt('password')
        ]);

        $gender = $faker->randomElement(['male', 'female']);

        $teacherUser = User::create([
            'first_name' => $faker->firstName($gender),
            'middle_name' => $faker->lastName($gender),
            'last_name' => $faker->lastName($gender),
            'phone_number' => $faker->phoneNumber(),
            'email' => 'teacher@teacher.com',
            'password' => bcrypt('password')
        ]);

        $adminUser->roles()->attach([$admin->id]);
        $studentUser->roles()->attach([$student->id]);
        $teacherUser->roles()->attach([$teacher->id]);

        Lecturer::create([
            'user_id' => $teacherUser->id,
            'phone_number' => $faker->phoneNumber(),
            'room_number' => $faker->numberBetween(1,500),
            'title' => $faker->jobTitle(),
        ]);
        
        $this->call(AcademicYearSeeder::class);
        $this->call(DegreeTypeSeeder::class);
        $this->call(EducationTypeSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(StudentStatusSeeder::class);
        $this->call(TuitionSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(StudyPlanSeeder::class);
        $this->call(StreamGroupSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(LecturerSeeder::class);
        $this->call(AttestationSeeder::class);
        $this->call(MarkSeeder::class);
        $this->call(DormitorySeeder::class);
        $this->call(DormitoryRoomSeeder::class);
        $this->call(CourseLecturerAssignmentsSeeder::class);


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
