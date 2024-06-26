<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Major;
use App\Models\StudyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudyPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.studyplans.index', ['studyplans' => StudyPlan::with('major', 'academicYear')->orderBy('status', 'asc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $majors = Major::all();
        $academicYears = AcademicYear::all();
        return view('admin.studyplans.create', compact('majors', 'academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'major_id' => 'required|exists:majors,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'status' => 'required|in:active,inactive',
        ]);

        StudyPlan::create($request->all());

        return redirect()->route('admin.studyplans.index')->with('success', 'Study plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StudyPlan $studyplan)
    {
        $studyPlan = StudyPlan::with(['courses' => function ($query) {
            $query->orderBy('pivot_semester', 'asc')->orderBy('id', 'asc');
        }])->find($studyplan->id);

        if (!$studyPlan) {
            return redirect()->route('admin.studyplans.index')->with('error', 'Study plan not found!');
        }

        $coursesBySemester = $studyPlan->courses->groupBy('pivot.semester');

        return view('admin.studyplans.show', compact('studyPlan', 'coursesBySemester'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudyPlan $studyplan)
    {
        $majors = Major::all();
        $academicYears = AcademicYear::all();
        return view('admin.studyplans.edit', compact('studyplan', 'majors', 'academicYears'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudyPlan $studyplan)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'major_id' => 'required|exists:majors,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'status' => 'required|in:active,inactive',
        ]);

        $updateStatus = $studyplan->update($validated);

        if (!$updateStatus) {
            return back()->with('error', 'Failed to update study plan.');
        }

        return redirect()->route('admin.studyplans.index')->with('success', 'Study plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyPlan $studyPlan)
    {
        $studyPlan->delete();
        return back()->with('success', 'Successfully deleted study plan!');
    }
}
