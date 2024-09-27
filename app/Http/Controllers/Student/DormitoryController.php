<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\DormitoryApplication;
use Illuminate\Http\Request;

class DormitoryController extends Controller
{
    public function index()
    {
        $accommodation = Accommodation::where('student_id', auth()->user()->student->id)->where('status', 'active')->latest()->first();
        $application = DormitoryApplication::where('student_id', auth()->user()->student->id)->first();
        return view('student.dormitory', compact('accommodation', 'application'));
    }
}
