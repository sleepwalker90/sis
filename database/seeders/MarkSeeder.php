<?php

namespace Database\Seeders;

use App\Models\Mark;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::with(['studyPlan.courses.attestations'])->get(); // Ensure attestations are loaded with courses
        foreach ($students as $student) {
            foreach ($student->studyPlan->courses as $course) {
                if ($course->pivot->semester > $student->started_semester) {
                    continue; // Skip courses that are not within the started semester
                }

                $requiredAttestations = collect(['Lecture', 'Lab', 'Seminar'])
                    ->filter(function ($type) use ($course) {
                        return $course->{'has' . $type}; // Check if the course requires this type of attestation
                    });

                $attested = $requiredAttestations->every(function ($type) use ($course, $student) {
                    return $student->attestations->contains(function ($attestation) use ($course, $type) {
                        return $attestation->course_id == $course->id && $attestation->type === $type && $attestation->is_attested;
                    });
                });

                if ($attested) {
                    // Create marks for each type as necessary
                    $this->createMark($student->id, $course->id, 'Exam', $course->hasExam);
                    $this->createMark($student->id, $course->id, 'Oa', $course->hasOa);
                    // $this->createMark($student->id, $course->id, 'Cw', $course->hasCw);
                    // $this->createMark($student->id, $course->id, 'Cp', $course->hasCw);
                }
            }
        }
    }

    protected function createMark($studentId, $courseId, $type, $condition)
    {
        if ($condition) {
            Mark::create([
                'student_id' => $studentId,
                'course_id' => $courseId,
                'mark' => rand(2, 6), // Random grading between 2 and 6
                'type' => $type
            ]);
        }
    }
}
