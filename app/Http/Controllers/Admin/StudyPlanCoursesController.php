<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudyPlan;
use Illuminate\Http\Request;

class StudyPlanCoursesController extends Controller
{
    public function detachCourse(StudyPlan $studyPlan, $courseId)
    {
        if ($studyPlan->courses()->find($courseId))
        {
            $studyPlan->courses()->detach($courseId);

            return back()->with('success', 'Successfully removed course from study plan!');
        } else {
            return back()->with('error', 'Course not found in this study plan.');
        }
    }

    public function showAttachCoursesForm(StudyPlan $studyPlan)
    {
        $attachedCourses = $studyPlan->courses;

        $availableCourses = Course::whereNotIn('id', $attachedCourses->pluck('id'))
            ->where(function($query) use ($studyPlan) { 
                $query->where('major_id', $studyPlan->major_id)
                    ->orWhereNull('major_id');
             })
             ->get();

        $attachedCourses = $attachedCourses->groupBy('pivot.semester');

        return view('admin.studyplans.courses.attach', [
            'attachedCourses' => $attachedCourses, 
            'availableCourses' => $availableCourses,
            'studyPlan' => $studyPlan
        ]);
    }

    public function attachCourse(StudyPlan $studyPlan, Request $request)
    {
        $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'semester' => 'required|integer|min:1|max:8'
        ]);
        $studyPlan->courses()->attach($request->course_id, ['semester' => $request->semester]);
        return back()->with('success', 'Successfully attached course to study plan!');
    }
}
