<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DegreeType;
use App\Models\EducationType;
use App\Models\Faculty;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.majors.index',['majors' => Major::with('faculty','degreeType', 'educationType')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.majors.create', ['faculties' => faculty::all(), 'degreeTypes' => DegreeType::all(), 'educationTypes' => EducationType::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_major = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'faculty_id' => ['required', 'exists:faculties,id'],
            'degree_type_id' => ['required', 'exists:degree_types,id'],
            'education_type_id' => ['required', 'exists:education_types,id'],
            'semesters' => ['required', 'integer', 'min:1', 'max:8'],
        ]);
        Major::create($new_major);
        return redirect()->route('admin.majors')->with([
            'success' => 'Successfully created new major!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Major $major)
    {
        return view('admin.majors.show', ['major' => $major]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Major $major)
    {
        return view('admin.majors.edit', ['major' => $major, 'faculties' => Faculty::all(), 'degreeTypes' => DegreeType::all(), 'educationTypes' => EducationType::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Major $major)
    {
        $update_major  = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'faculty_id' => ['required', 'exists:faculties,id'],
            'degree_type_id' => ['required', 'exists:degree_types,id'],
            'education_type_id' => ['required', 'exists:education_types,id']
        ]);

        $major->update($update_major);
        return redirect()->route('admin.majors')->with([
            'success' => 'Successfully updated major!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major)
    {
        $major->courses()->count() > 0 || $major->students()->count() > 0 ? abort(403, 'You cannot delete a major that has courses or students.') : $major->delete();
        return back()->with('success', 'Successfully deleted major!');
    }
}
