<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLecturerAssignment;
use App\Models\Student;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function show(CourseLecturerAssignment $assignment)
    {
        $students = Student::whereHas('group', function ($query) use ($assignment) {
            $query->where('stream_id', $assignment->stream_id);
        })->with('marks', 'user', 'group', 'attestations')->get();

        return view('admin.marks.show', compact('students', 'assignment'));
    }

    public function store(Request $request, CourseLecturerAssignment $assignment)
    {
        $validated = $request->validate([
            'marks' => 'required|array',
            'marks.*.*.student_id' => 'required|exists:students,id',
            'marks.*.*.type' => 'required|in:exam,cw,oa,cp',
            'marks.*.*.mark' => 'nullable|numeric|between:2,6',
        ]);

        foreach ($validated['marks'] as $studentId => $studentMarks) {
            foreach ($studentMarks as $type => $markData) {
                if (isset($markData['student_id']) && isset($markData['type']) && array_key_exists('mark', $markData)) {

                    $student = Student::find($markData['student_id']);
                    $student->marks()->updateOrCreate(
                        [
                            'course_id' => $assignment->course_id,
                            'type' => $markData['type'],
                        ],
                        [
                            'mark' => $markData['mark'],
                        ]
                    );
                }
            }
        }

        return redirect()->route('admin.marks.show', $assignment)->with('success', 'Marks updated successfully.');
    }
}
