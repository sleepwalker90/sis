<?php

namespace App\Services;

use App\Models\Mark;
use App\Models\Setting;
use App\Models\Student;

class ScholarshipService
{
    public function evaluateEligibility(Student $student)
    {
        // TODO: Evaluate eligibility for scholarship
        $currentSemester = $student->certified_semester;
        $semstersToCheck = [$currentSemester, $currentSemester - 1];

        $perfectAmount = $this->getSetting('scholarship_top_amount');
        $excelentAmount = $this->getSetting('scholarship_excelent_amount');

        $gpa = $this->calculateGPA($student, $semstersToCheck);
        $hasFailedExams = $this->hasFailedExams($student, $currentSemester);

        $hasApplied = $student->scholarships()->where('semester', $currentSemester)->exists();

        $returnValue = ['eligible' => true, 'amount' => null, 'gpa' => $gpa, 'hasApplied' => $hasApplied];
        
        if ($hasApplied) {
            $application = $student->scholarships()->where('semester', $currentSemester)->first();
            $returnValue['applicationStatus'] = $application->status;
        }

        if ($currentSemester == 1) {
            $returnValue['eligible'] = false;
            $returnValue['reason'] = 'First semester';
            return $returnValue;
        }

        if ($hasFailedExams) {
            $returnValue['eligible'] = false;
            $returnValue['reason'] = 'Failed Exams';
            return $returnValue;
        }

        if ($gpa == 6.00) {
            $returnValue['amount'] = $perfectAmount;
            return $returnValue;
        } elseif ($gpa >= 5.50 && $gpa < 6.00) {
            $returnValue['amount'] = $excelentAmount;
            return $returnValue;
        }

        $returnValue['eligible'] = false;
        $returnValue['reason'] = 'GPA too low.';
        return $returnValue;
    }

    private function calculateGPA(Student $student, array $semesters)
    {
        
        $courseIds = $student->studyPlan->courses()
            ->wherePivotIn('semester', $semesters)
            ->pluck('id');

        $marks = Mark::where('student_id', $student->id)
            ->whereIn('course_id', $courseIds)
            ->whereNotNull('mark')  
            ->get();

        if ($marks->isEmpty()) {
            return 0; // Return a GPA of 0 if no marks are available
        }

        $totalMarks = $marks->sum('mark');
        $count = $marks->count();

        return $count > 0 ? $totalMarks / $count : 0;
    }


    private function hasFailedExams(Student $student, int $semester)
    {
        return Mark::where('student_id', $student->id)
            ->where('mark', '<', 3)
            ->whereHas('course', function ($query) use ($semester, $student) {
                $query->join('study_plan_courses', 'courses.id', '=', 'study_plan_courses.course_id')
                    ->where('study_plan_courses.study_plan_id', $student->studyPlan->id)
                    ->where('study_plan_courses.semester', '<=', $semester);
            })
            ->exists();
    }

    protected function getSetting($key)
    {
        return Setting::where('key', $key)->value('value');
    }
}
