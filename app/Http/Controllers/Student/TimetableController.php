<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseSchedule;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
{
    $student = auth()->user()->student;

    $groupSchedules = CourseSchedule::whereHas('courseLecturerAssignment', function ($query) use ($student) {
        $query->where('stream_id', $student->group->stream_id)
              ->where(function ($subQuery) use ($student) {
                  $subQuery->where('group_id', $student->group_id)
                           ->orWhereNull('group_id');
              });
    })
    ->with('courseLecturerAssignment.course', 'courseLecturerAssignment.lecturer.user')
    ->orderBy('day_of_week', 'asc')
    ->orderBy('start_time', 'asc')
    ->get();

    return view('student.timetable', compact('groupSchedules'));
}

}
