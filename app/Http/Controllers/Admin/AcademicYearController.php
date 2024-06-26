<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Rules\ValidAcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::all();
        return view('admin.academic-years.index', compact('academicYears'));
    }

    public function create()
    {
        $academicYear = new AcademicYear();
        return view('admin.academic-years.create', compact('academicYear'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => ['required','string','unique:academic_years,year', new ValidAcademicYear()],
        ]);

        AcademicYear::create($request->all());

        return redirect()->route('admin.academic-years.index')->with('success', 'Academic Year created successfully.');
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('admin.academic-years.create', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->validate([
            'year' => ['required','string','unique:academic_years,year,' . $academicYear->id, new ValidAcademicYear()],
        ]);

        $academicYear->update($request->all());

        return redirect()->route('admin.academic-years.index')->with('success', 'Academic Year updated successfully.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();
        return redirect()->route('admin.academic-years.index')->with('success', 'Academic Year deleted successfully.');
    }
}
