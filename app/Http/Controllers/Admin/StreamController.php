<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stream;
use App\Models\StudyPlan;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    public function index()
    {
        $streams = Stream::with('studyPlan', 'academicYear')->get();
        return view('admin.streams.index', compact('streams'));
    }

    public function create()
    {
        $studyPlans = StudyPlan::all();
        $academicYears = AcademicYear::all();
        $stream = new Stream();
        return view('admin.streams.create', compact('studyPlans', 'academicYears', 'stream'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|integer',
            'study_plan_id' => 'required|exists:study_plans,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        // Ensure unique stream number within the same academic year
        $exists = Stream::where('number', $request->number)
            ->where('academic_year_id', $request->academic_year_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['number' => 'The stream number already exists for the given academic year.']);
        }

        Stream::create($request->all());

        return redirect()->route('admin.streams.index')->with('success', 'Stream created successfully.');
    }

    public function edit(Stream $stream)
    {
        $stream = Stream::with('studyPlan', 'academicYear', 'groups')->find($stream->id);
        $studyPlans = StudyPlan::all();
        $academicYears = AcademicYear::all();
        return view('admin.streams.create', compact('stream', 'studyPlans', 'academicYears'));
    }

    public function update(Request $request, Stream $stream)
    {
        $request->validate([
            'number' => 'required|integer',
            'study_plan_id' => 'required|exists:study_plans,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        // Ensure unique stream number within the same academic year
        $exists = Stream::where('number', $request->number)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('id', '!=', $stream->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['number' => 'The stream number already exists for the given academic year.']);
        }

        $stream->update($request->all());

        return redirect()->route('admin.streams.index')->with('success', 'Stream updated successfully.');
    }

    public function destroy(Stream $stream)
    {
        $stream->delete();
        return redirect()->route('admin.streams.index')->with('success', 'Stream deleted successfully.');
    }
}
