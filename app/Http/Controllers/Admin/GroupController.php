<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Stream;
use App\Models\AcademicYear;
use App\Models\Student;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('stream', 'academicYear')->get();
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        $streams = Stream::all()->sortBy('number');
        $academicYears = AcademicYear::all();
        return view('admin.groups.create', compact('streams', 'academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|integer',
            'stream_id' => 'required|exists:streams,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        // Ensure unique group number within the same academic year
        $exists = Group::where('number', $request->number)
            ->where('academic_year_id', $request->academic_year_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['number' => 'The group number already exists for the given academic year.']);
        }

        Group::create($request->all());

        return redirect()->route('admin.groups.index')->with('success', 'Group created successfully.');
    }

    public function edit(Group $group)
    {
        $group = Group::with('stream', 'academicYear', 'students')->find($group->id);
        return view('admin.groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'number' => 'required|integer',
            'stream_id' => 'required|exists:streams,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        // Ensure unique group number within the same academic year
        $exists = Group::where('number', $request->number)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('id', '!=', $group->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['number' => 'The group number already exists for the given academic year.']);
        }

        $group->update($request->all());

        return redirect()->route('admin.groups.index')->with('success', 'Group updated successfully.');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index')->with('success', 'Group deleted successfully.');
    }

    public function addStudents(Group $group)
    {
        $students = Student::where('study_plan_id', $group->stream->study_plan_id)
                        ->whereNull('group_id')
                        ->with('user')
                        ->get();
        return view('admin.groups.add_students', compact('group', 'students'));
    }

    public function storeStudents(Request $request, Group $group)
    {
        $student = Student::findOrFail($request->student_id);
        $student->update([
            'group_id' => $group->id
        ]);
        return redirect()->route('admin.groups.edit', $group->id)->with('success', 'Student added to group successfully.');
    }
}
