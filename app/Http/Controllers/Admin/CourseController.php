<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.courses.index',['courses' => Course::with('major')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create',['majors' => Major::all(), 'ecourses' => Course::where('is_elective_group', true)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $checkboxes = ['hasLectures', 'hasSeminars', 'hasLabs', 'hasExam', 'hasOa', 'hasCp', 'hasCw', 'is_elective_group'];
        foreach ($checkboxes as $checkbox) {
            $request->merge([$checkbox => $request->has($checkbox)]);
        }

        if($request->is_elective_group && $request->elective_course_group_id !== null) {
            return back()->withErrors('A course cannot be an elective group and belong to another elective group.');
        }

        $attributes = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:courses,code',
            'credits' => 'required|integer',
            'major_id' => 'nullable|exists:majors,id',
            'hasLectures' => 'nullable|boolean',
            'hasSeminars' => 'nullable|boolean',
            'hasLabs' => 'nullable|boolean',
            'hasExam' => 'nullable|boolean',
            'hasOa' => 'nullable|boolean',
            'hasCp' => 'nullable|boolean',
            'hasCw' => 'nullable|boolean',
            'is_elective_group' => 'nullable|boolean',
            'elective_course_group_id' => 'nullable|exists:courses,id',
        ]);

       
        Course::create($attributes);

        return redirect()->route('admin.courses')->with('success', 'Successfully created new course!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', ['course' => $course]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $majors = Major::all();
        $ecourses = Course::where('is_elective_group', true)->get();
        return view('admin.courses.edit', compact('course', 'majors', 'ecourses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return back()->with('success', 'Successfully deleted course!');
    }
}
