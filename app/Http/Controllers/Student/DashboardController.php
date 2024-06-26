<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLecturerAssignment;
use App\Models\Scholarship;
use App\Models\Student;
use App\Models\User;
use App\Services\ScholarshipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $scholarshipService;

    public function __construct(ScholarshipService $scholarshipService)
    {
        $this->scholarshipService = $scholarshipService;
    }

    public function showGeneralInfo()
    {
        return view('student.dashboard');
    }

    public function showCourses()
    {
        $user = Auth::user();
        if (!$user->student || !$user->student->studyPlan) {
            return back()->withError('No study plan found.');
        }

        // Fetch courses with related certifications and marks using eager loading
        $studentId = $user->student->id;

        $courses = $user->student->studyPlan->courses()
            ->with([
                'attestations' => function ($query) use ($studentId) {
                    // Filter attestations by student_id
                    $query->where('student_id', $studentId);
                },
                'marks' => function ($query) use ($studentId) {
                    // Filter marks by student_id
                    $query->where('student_id', $studentId);
                }
            ])
            ->wherePivot('semester', '<=', $user->student->started_semester)
            ->get()
            ->groupBy('pivot.semester');

        return view('student.courses', [
            'coursesBySemester' => $courses ?? [],
        ]);
    }

    public function showScholarshipStatus()
    {
        $student = Auth::user()->student;

        $result = $this->evaluateStudentEligibility($student);

        return view('student.scholarship', ['result' => $result]);
    }

    public function applyForScholarship()
    {
        $student = Auth::user()->student;
        $result = $this->evaluateStudentEligibility($student);

        if (!$result['eligible']) {
            return back()->with('error', 'Not eligible to apply for a scholarship.');
        }

        $academicYear = $this->getAcademicYear();
        $currentSemester = $student->certified_semester;

        $existingApplication = $student->scholarships()
            ->where('semester', $currentSemester)
            ->where('academic_year', $academicYear)
            ->first();
        if ($existingApplication) {
            return back()->with('error', 'You have already applied for a scholarship this semester.');
        }

        Scholarship::create([
            'student_id' => $student->id,
            'gpa' => $result['gpa'],
            'semester' => $student->certified_semester,
            'academic_year' => $academicYear,
            'status' => 'in review'
        ]);

        return back()->with('success', 'Scholarship application submitted successfully.');
    }

    protected function evaluateStudentEligibility($student)
    {
        if (!$student || !$student->studyPlan) {
            return ['eligible' => false, 'error' => 'No study plan found.', 'gpa' => null, 'amount' => null];
        }

        return $this->scholarshipService->evaluateEligibility($student);
    }

    private function getAcademicYear()
    {
        $currentYear = now()->year;
        $nextYear = $currentYear + 1;
        $previousYear = $currentYear - 1;

        // Format academic year based on current month
        if (now()->month >= 7) {
            return $currentYear . '/' . $nextYear;
        } else {
            return $previousYear . '/' . $currentYear;
        }
    }

    public function showCourseLecturer(Course $course)
    {
        $user = Auth::user();
        $studyPlanId = $user->student->study_plan_id;
        $streamId = $user->student->group->stream_id;

        $assignments = CourseLecturerAssignment::where('course_id', $course->id)
            ->where('study_plan_id', $studyPlanId)
            ->where('stream_id', $streamId)
            ->get();

        if ($assignments->isEmpty()) {
            return back()->with('error', 'No lecturer assigned to this course.');
        }

        $lecturers = $assignments->map(function ($assignment) {
            $lecturer = $assignment->lecturer;
            $lecturer->office_hours = json_decode($lecturer->office_hours, true);
            return $lecturer;
        });

        return view('student.course-lecturer', compact('course', 'lecturers'));
    }
}
