<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DormitoryApplication;
use App\Models\DormitoryApplicationPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DormitoryApplicationController extends Controller
{
   public function create()
   {
      $activePeriod = DormitoryApplicationPeriod::whereDate('start_date', '<=', now())
                                                ->whereDate('end_date', '>=', now())
                                                ->first();

      if (!$activePeriod) {
         return redirect()->back()->with('error', 'Dormitory applications are not open at this time!');
      }

      return view('dormitory-application.create');
   }

   public function store(Request $request)
   {
      // $activePeriod = DormitoryApplicationPeriod::whereDate('start_date', '<=', now())
      //                                           ->whereDate('end_date', '>=', now())
      //                                           ->first();

      // if (!$activePeriod) {
      //    return redirect()->back()->with('error', 'Dormitory applications are not open at this time!');
      // }

      $student = Auth::user()->student;
      if (!$student) {
         return redirect()->back()->with('error', 'You are not authorized to apply for a dormitory!');
      }

      DormitoryApplication::create([
          'student_id' => Auth::user()->student->id,
          'status' => 'pending',
          'academic_year' => $this->getAcademicYear(),
      ]);

      return redirect()->back()->with('success', 'Dormitory application submitted successfully!');
   }

   private function getAcademicYear()
    {
        $currentMonth = now()->month;
        if ($currentMonth >= 9) {
            return now()->year . '/' . (now()->year + 1);
        } else {
            return (now()->year - 1) . '/' . now()->year;
        }
    }
}
