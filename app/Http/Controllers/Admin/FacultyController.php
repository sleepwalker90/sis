<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.faculties.index',['faculties' => Faculty::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faculties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_faculty = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        Faculty::create($new_faculty);
        return redirect()->route('admin.faculties')->with([
            'success' => 'Successfully created new faculty!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faculty $faculty)
    {
        return view('admin.faculties.edit', ['faculty' => $faculty]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faculty $faculty)
    {
        $update_faculty  = $request->validate([
            'name' => ['required', 'string', 'max:255','unique:faculties,name,'.$faculty->id],

        ]);
        $faculty->update($update_faculty);
        return redirect()->route('admin.faculties')->with([
            'success' => 'Successfully updated faculty!'
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        //I want to delete a faculty only if it has no majors.
        $faculty->majors()->count() > 0 ? abort(403, 'You cannot delete a faculty that has majors.') : $faculty->delete();
        return back()->with('success', 'Successfully deleted faculty!');
    }
}
