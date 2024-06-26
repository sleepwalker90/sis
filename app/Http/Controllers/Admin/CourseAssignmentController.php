<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Stream;
use App\Models\StudyPlan;
use App\Models\CourseLecturerAssignment;
use Illuminate\Http\Request;

class CourseAssignmentController extends Controller
{
    public function show(Request $request)
    {
        $studyPlanId = $request->input('study_plan_id');
        $courseId = $request->input('course_id');

        $studyPlan = StudyPlan::findOrFail($studyPlanId);
        $course = Course::findOrFail($courseId);

        $streams = Stream::where('study_plan_id', $studyPlanId)->get();

        $assignedLecturers = CourseLecturerAssignment::where('course_id', $courseId)
            ->where('study_plan_id', $studyPlanId)
            ->get();

        $lecturers = $course->preferredLecturers()
            ->whereNotIn('lecturer_id', $assignedLecturers->pluck('lecturer_id')->toArray())
            ->with('user')->get();

        return view('admin.course_assignments.show', compact('studyPlan', 'course', 'lecturers', 'streams', 'assignedLecturers'));
    }

    public function assign(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'study_plan_id' => 'required|exists:study_plans,id',
            'stream_id' => 'required|exists:streams,id',
        ]);

        $exists = CourseLecturerAssignment::where('course_id', $request->course_id)
            ->where('study_plan_id', $request->study_plan_id)
            ->where('stream_id', $request->stream_id)
            ->where('lecturer_id', $request->lecturer_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'The lecturer is already assigned to this course, study plan, and stream.');
        }

        CourseLecturerAssignment::create($validated);

        return redirect()->back()->with('success', 'Course assigned successfully.');
    }

    public function unassign(CourseLecturerAssignment $assignment)
    {
        $assignment->delete();

        return redirect()->back()->with('success', 'Lecturer unassigned successfully.');
    }
}
