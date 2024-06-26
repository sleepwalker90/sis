<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\CourseLecturerAssignment;
use App\Models\Student;
use Illuminate\Http\Request;

class AttestationController extends Controller
{
    public function index()
    {
        $lecturer = auth()->user()->lecturer;
        $assignments = CourseLecturerAssignment::with('course', 'stream')
            ->where('lecturer_id', $lecturer->id)
            ->get();

        return view('lecturer.attestations.index', compact('assignments'));
    }

    public function show(CourseLecturerAssignment $assignment)
    {
        $students = Student::whereHas('group', function ($query) use ($assignment) {
            $query->where('stream_id', $assignment->stream_id);
        })->with('attestations', 'user', 'group')->get();

        return view('lecturer.attestations.show', compact('students', 'assignment'));
    }

    public function store(Request $request, CourseLecturerAssignment $assignment)
    {
        $validated = $request->validate([
            'attestations' => 'required|array',
            'attestations.*.Lecture.student_id' => 'nullable|exists:students,id',
            'attestations.*.Lecture.type' => 'nullable|in:Lecture,Lab,Seminar',
            'attestations.*.Lecture.is_attested' => 'nullable|boolean',
            'attestations.*.Seminar.student_id' => 'nullable|exists:students,id',
            'attestations.*.Seminar.type' => 'nullable|in:Lecture,Lab,Seminar',
            'attestations.*.Seminar.is_attested' => 'nullable|boolean',
            'attestations.*.Lab.student_id' => 'nullable|exists:students,id',
            'attestations.*.Lab.type' => 'nullable|in:Lecture,Lab,Seminar',
            'attestations.*.Lab.is_attested' => 'nullable|boolean',
        ]);

        foreach ($validated['attestations'] as $studentId => $attestationTypes) {
            foreach ($attestationTypes as $type => $data) {
                if ($data['student_id'] && $data['type']) {
                    $student = Student::find($data['student_id']);
                    $student->attestations()->updateOrCreate([
                        'course_id' => $assignment->course_id,
                        'type' => $data['type'],
                    ], [
                        'is_attested' => isset($data['is_attested']) ? $data['is_attested'] : false,
                    ]);
                }
            }
        }

        return redirect()->route('lecturer.attestations.show', $assignment)->with('success', 'Attestations updated successfully.');
    }
}
