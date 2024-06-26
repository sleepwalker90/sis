<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\CourseLecturerAssignment;
use App\Models\CourseSchedule;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $lecturer = auth()->user()->lecturer;

        $lecturerSchedules = CourseSchedule::whereHas('courseLecturerAssignment', function ($query) use ($lecturer) {
            $query->where('lecturer_id', $lecturer->id);
        })->with('courseLecturerAssignment.course', 'courseLecturerAssignment.stream.groups')->get();

        return view('lecturer.timetable', compact('lecturerSchedules'));
    }
}
