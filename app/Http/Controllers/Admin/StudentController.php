<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Student;
use App\Models\StudyPlan;
use App\Models\Tuition;
use App\Models\User;
use App\Rules\Egn;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedMajor = $request->input('major_id');
        $selectedStudyPlan = $request->input('study_plan_id');
        $searchQuery = $request->input('search');

        $majors = Major::all();
        $studyPlans = StudyPlan::all();

        $students = Student::with(['user', 'major', 'studyPlan']);

        if ($selectedMajor) {
            $students = $students->where('major_id', $selectedMajor);
        }

        if ($selectedStudyPlan) {
            $students = $students->where('study_plan_id', $selectedStudyPlan);
        }

        if ($searchQuery) {
            $students = $students->whereHas('user', function($query) use ($searchQuery) {
                $query->where('first_name', 'like', "%{$searchQuery}%")
                    ->orWhere('last_name', 'like', "%{$searchQuery}%")
                    ->orWhere('email', 'like', "%{$searchQuery}%");
            })
            ->orWhere('fn', 'like', "%{$searchQuery}%");
            // ->orWhere('egn', 'like', "%{$searchQuery}%");
        }

        $students = $students->get();

        return view('admin.students.index', compact('students', 'majors', 'studyPlans', 'selectedMajor', 'selectedStudyPlan', 'searchQuery'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Major::all();
        $studyPlans = StudyPlan::all();
        $tuitions = Tuition::all();

        return view('admin.students.create', compact('majors', 'studyPlans', 'tuitions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'egn' => ['required', new Egn],
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:255',
            'major_id' => 'required|exists:majors,id',
            'study_plan_id' => 'required|exists:study_plans,id',
            'tuition_id' => 'required|exists:tuitions,id',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => bcrypt('password'), // Set a default password
        ]);

        $studyPlan = StudyPlan::findOrFail($validated['study_plan_id']);
        $academicYear = $studyPlan->academicYear->year;
        $facultyNumber = $this->generateFacultyNumber($validated['major_id'], $academicYear);

        Student::create([
            'user_id' => $user->id,
            'fn' => $facultyNumber,
            'major_id' => $validated['major_id'],
            'egn' => $validated['egn'],
            'started_semester' => 0, // Default value for started semester
            'certified_semester' => 0, // Default value for certified semester
            'study_plan_id' => $validated['study_plan_id'],
            'tuition_id' => $validated['tuition_id'],
            'student_status_id' => 1, // Assuming status id 1(active) for new students
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
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
    public function edit(Student $student)
    {
        $majors = Major::all();
        $studyPlans = StudyPlan::all();
        $tuitions = Tuition::all();
        return view('admin.students.edit', compact('student', 'majors', 'studyPlans','tuitions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'phone_number' => 'nullable|string|max:255',
            'major_id' => 'required|exists:majors,id',
            'study_plan_id' => 'required|exists:study_plans,id',
            'tuition_id' => 'required|exists:tuitions,id',
        ]);

        $student->user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
        ]);

        $student->update([
            'major_id' => $validated['major_id'],
            'study_plan_id' => $validated['study_plan_id'],
            'tuition_id' => $validated['tuition_id'],
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }

    protected function generateFacultyNumber($majorId, $academicYear)
    {
        $facultyId = Major::findOrFail($majorId)->faculty_id;
        $prefix = $facultyId . $majorId . substr($academicYear, 0, 4); // Format: faculty_id . major_id . first 4 digits of the academic year

        $latestStudent = Student::where('fn', 'like', $prefix . '%')
            ->orderBy('fn', 'desc')
            ->first();

        if ($latestStudent) {
            $lastNumber = (int)substr($latestStudent->fn, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return $prefix . $newNumber;
    }
}
