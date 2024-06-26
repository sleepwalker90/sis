<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with('user')->get();

        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.lecturers.create', compact('courses'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:255',
            'room_number' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => bcrypt('password'), // Set a default password
        ]);

        $user->assignRole('Teacher');

        $lecturer = Lecturer::create([
            'user_id' => $user->id,
            'phone_number' => $validated['phone_number'],
            'room_number' => $validated['room_number'],
            'title' => $validated['title'],
        ]);

        if ($request->has('courses')) {
            $lecturer->preferredCourses()->sync($request->courses);
        }

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer created successfully.');
    }

    public function edit(Lecturer $lecturer)
    {
        return view('admin.lecturers.edit', compact('lecturer'));
    }



    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $lecturer->user_id,
            'phone_number' => 'required|string|max:255|unique:lecturers,phone_number,' . $lecturer->id,
            'room_number' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ]);

        $lecturer->user->update([
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        $lecturer->update([
            'phone_number' => $request->input('phone_number'),
            'room_number' => $request->input('room_number'),
            'title' => $request->input('title'),
        ]);

        if ($request->has('courses')) {
            $lecturer->preferredCourses()->sync($request->courses);
        }

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer updated successfully.');
    }

    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer deleted successfully.');
    }
}
