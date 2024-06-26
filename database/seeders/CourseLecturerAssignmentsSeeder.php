<?php

namespace Database\Seeders;

use App\Models\CourseLecturerAssignment;
use App\Models\Lecturer;
use App\Models\StudyPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseLecturerAssignmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $studyPlans = StudyPlan::where('major_id', 16)->with(['courses', 'streams'])->get();

        foreach ($studyPlans as $studyPlan) {
            foreach ($studyPlan->courses as $course) {
                foreach ($studyPlan->streams as $stream) {
                    $lecturers = Lecturer::whereHas('preferredCourses', function ($query) use ($course) {
                        $query->where('course_id', $course->id);
                    })->get();

                    if ($lecturers->isNotEmpty()) {
                        $lecturers = $lecturers->random(1,2);
                        
                        foreach($lecturers as $lecturer) {
                            CourseLecturerAssignment::create([
                                'course_id' => $course->id,
                                'study_plan_id' => $studyPlan->id,
                                'lecturer_id' => $lecturer->id,
                                'stream_id' => $stream->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
