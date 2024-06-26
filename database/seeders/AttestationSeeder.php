<?php

namespace Database\Seeders;

use App\Models\Attestation;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttestationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::with('studyPlan.courses')->get();

        foreach ($students as $student) {
            foreach ($student->studyPlan->courses()->wherePivot('semester', '<=', $student->started_semester)->get() as $course) {
                if ($course->hasLectures) {
                    Attestation::create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'type' => 'Lecture',
                        'is_attested' => (bool)rand(0, 1) // Randomly decide if certified or not
                    ]);
                }

                if ($course->hasLabs) {
                    Attestation::create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'type' => 'Lab',
                        'is_attested' => (bool)rand(0, 1)
                    ]);
                }

                if ($course->hasSeminars) {
                    Attestation::create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'type' => 'Seminar',
                        'is_attested' => (bool)rand(0, 1)
                    ]);
                }
            }

        }
    }
}
