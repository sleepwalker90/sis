<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLecturerAssignment;
use App\Models\CourseSchedule;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseScheduleController extends Controller
{
    public function index()
    {
        $courseSchedules = CourseSchedule::with('courseLecturerAssignment.course', 'courseLecturerAssignment.lecturer.user', 'courseLecturerAssignment.studyPlan', 'courseLecturerAssignment.stream', 'group')->get();
        return view('admin.course_schedules.index', compact('courseSchedules'));
    }

    public function create(CourseLecturerAssignment $courseLecturerAssignment)
    {
        $courseLecturerAssignment->load('course', 'lecturer.user', 'studyPlan', 'stream');

        $groups = $courseLecturerAssignment->stream->groups;

        $lecturerSchedules = CourseSchedule::whereHas('courseLecturerAssignment', function ($query) use ($courseLecturerAssignment) {
            $query->where('lecturer_id', $courseLecturerAssignment->lecturer_id);
        })->orderBy('day_of_week', 'asc')->orderBy('start_time', 'asc')->get();

        $streamSchedules = CourseSchedule::whereHas('courseLecturerAssignment', function ($query) use ($courseLecturerAssignment) {
            $query->where('stream_id', $courseLecturerAssignment->stream_id)->where('group_id', null);
        })->orderBy('day_of_week', 'asc')->orderBy('start_time', 'asc')->get();

        $groupSchedules = CourseSchedule::whereHas('courseLecturerAssignment', function ($query) use ($courseLecturerAssignment) {
            $query->whereIn('group_id', $courseLecturerAssignment->stream->groups->pluck('id'));
        })->orderBy('day_of_week', 'asc')->orderBy('group_id', 'asc')->orderBy('start_time', 'asc')->get();

        $validClassTypes = [];
        if ($courseLecturerAssignment->course->hasLectures) $validClassTypes[] = 'lecture';
        if ($courseLecturerAssignment->course->hasSeminars) $validClassTypes[] = 'seminar';
        if ($courseLecturerAssignment->course->hasLabs) $validClassTypes[] = 'lab';

        return view('admin.course_schedules.create', compact('courseLecturerAssignment', 'groups', 'lecturerSchedules', 'streamSchedules', 'groupSchedules', 'validClassTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_lecturer_assignment_id' => 'required|exists:course_lecturer_assignments,id',
            'class_type' => 'required|in:lecture,seminar,lab',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'group_id' => 'required_if:class_type,seminar,lab|nullable|exists:groups,id',
        ]);

        $courseLecturerAssignment = CourseLecturerAssignment::findOrFail($request->course_lecturer_assignment_id);
        $lecturerSchedules = CourseSchedule::whereHas('courseLecturerAssignment', function ($query) use ($courseLecturerAssignment) {
            $query->where('lecturer_id', $courseLecturerAssignment->lecturer_id);
        })->get();

        $streamSchedules = CourseSchedule::whereHas('courseLecturerAssignment', function ($query) use ($courseLecturerAssignment) {
            $query->where('stream_id', $courseLecturerAssignment->stream_id);
        })->get();

        $groupSchedules = CourseSchedule::whereHas('courseLecturerAssignment', function ($query) use ($courseLecturerAssignment) {
            $query->whereIn('group_id', $courseLecturerAssignment->stream->groups->pluck('id'));
        })->get();

        // Check for overlapping schedules
        $allSchedules = $lecturerSchedules->merge($streamSchedules)->merge($groupSchedules);

        // Check for overlapping schedules
        foreach ($allSchedules as $schedule) {
            if ($schedule->day_of_week === $request->day_of_week) {
                $scheduleStart = strtotime($schedule->start_time);
                $scheduleEnd = strtotime($schedule->end_time);
                $requestStart = strtotime($request->start_time);
                $requestEnd = strtotime($request->end_time);
                $requestGroupId = $request->group_id ? (int) $request->group_id : null;

                if ($requestEnd < $requestStart) {
                    return back()->withErrors(['schedule' => 'The selected start time cannot be after the end time.']);
                }
                if (
                    (
                        ($requestStart >= $scheduleStart && $requestStart <= $scheduleEnd) ||
                        ($requestEnd >= $scheduleStart && $requestEnd <= $scheduleEnd)
                    ) &&
                    $courseLecturerAssignment->lecturer_id === $schedule->courseLecturerAssignment->lecturer_id
                ) {
                    return back()->withErrors(['schedule' => 'The selected time slot overlaps with an existing lecturer schedule.']);
                }

                if (($requestStart >= $scheduleStart && $requestStart <= $scheduleEnd) || ($requestEnd >= $scheduleStart && $requestEnd <= $scheduleEnd)) {
                    if (($request->class_type === 'seminar' || $request->class_type === 'lab') && $schedule->group_id === $requestGroupId) {
                        return back()->withErrors(['schedule' => 'The selected time slot overlaps with an existing schedule for this group.']);
                    } elseif ($request->class_type === 'lecture') {
                        return back()->withErrors(['schedule' => 'The selected time slot overlaps with an existing schedule.']);
                    }
                }
            }
        }

        CourseSchedule::create([
            'course_lecturer_assignment_id' => $request->course_lecturer_assignment_id,
            'class_type' => $request->class_type,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'group_id' => $request->group_id,
        ]);

        return redirect()->back()->with('success', 'Schedule created successfully.');
    }


    public function destroy(CourseSchedule $courseSchedule)
    {
        $courseSchedule->delete();
        return back()->with('success', 'Course schedule deleted successfully.');
    }
}
