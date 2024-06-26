<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Payment;
use App\Models\StudyPlan;
use App\Models\Dormitory;

class PaymentController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = Payment::with('student.user');

    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $query->whereHas('student', function ($q) use ($search) {
    //             $q->where('fn', 'like', "%{$search}%")
    //                 // ->orWhere('egn', 'like', "%{$search}%")
    //                 ->orWhereHas('user', function ($q2) use ($search) {
    //                     $q2->where('first_name', 'like', "%{$search}%")
    //                         ->orWhere('last_name', 'like', "%{$search}%")
    //                         ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"])
    //                         ->orWhereRaw("CONCAT(last_name, ' ', first_name) like ?", ["%{$search}%"]);
    //                 });
    //         });
    //     }

    //     if ($request->has('type')) {
    //         $type = $request->input('type');
    //         if ($type !== 'all') {
    //             $query->where('type', $type);
    //         }
    //     }

    //     $payments = $query->paginate(15);

    //     return view('admin.payments.index', compact('payments'));
    // }

    public function index(Request $request)
    {
        $query = Payment::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student.user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('fn', 'like', "%{$search}%")
                    ->orWhere('egn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }

        $payments = $query->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }



    public function create()
    {
        $students = Student::with('user')->get();
        $studyPlans = StudyPlan::all();
        $dormitories = Dormitory::all();

        return view('admin.payments.create', compact('students', 'studyPlans', 'dormitories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'payment_option' => 'required|in:individual,study_plan,dormitory',
            'payment_type' => 'required|in:semester_tax,dorm_rent,utilities',
            'amount' => 'required|numeric|min:0',
            'student_id' => 'required_if:payment_option,individual|exists:students,id',
            'study_plan_id' => 'required_if:payment_option,study_plan|exists:study_plans,id',
            'dormitory_id' => 'required_if:payment_option,dormitory|exists:dormitories,id',
        ]);

        $paymentOption = $validatedData['payment_option'];
        $paymentType = $validatedData['payment_type'];
        $amount = $validatedData['amount'];

        switch ($paymentOption) {
            case 'individual':
                $studentId = $validatedData['student_id'];
                Payment::create([
                    'student_id' => $studentId,
                    'amount' => $amount,
                    'status' => 'pending',
                    'type' => $paymentType,
                ]);
                break;
            case 'study_plan':
                $studyPlanId = $validatedData['study_plan_id'];
                $students = Student::where('study_plan_id', $studyPlanId)->get();
                foreach ($students as $student) {
                    Payment::create([
                        'student_id' => $student->id,
                        'amount' => $amount,
                        'status' => 'pending',
                        'type' => $paymentType,
                    ]);
                }
                break;
            case 'dormitory':
                $dormitoryId = $validatedData['dormitory_id'];
                $students = Student::whereHas('accommodations', function ($query) use ($dormitoryId) {
                    $query->where('dormitory_id', $dormitoryId)->where('status', 'active');
                })->get();
                foreach ($students as $student) {
                    Payment::create([
                        'student_id' => $student->id,
                        'amount' => $amount,
                        'status' => 'pending',
                        'type' => $paymentType,
                    ]);
                }
                break;
        }

        return redirect()->route('admin.payments.index')->with('success', 'Payment(s) created successfully.');
    }


    public function assignPayment(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required',
            'amount' => 'required|numeric',
        ]);

        Payment::create([
            'student_id' => $request->student_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Payment assigned successfully.');
    }

    public function assignPaymentToStudyPlan(Request $request)
    {
        $request->validate([
            'study_plan_id' => 'required|exists:study_plans,id',
            'type' => 'required',
            'amount' => 'required|numeric',
        ]);

        $students = Student::where('study_plan_id', $request->study_plan_id)->get();

        foreach ($students as $student) {
            Payment::create([
                'student_id' => $student->id,
                'type' => $request->type,
                'amount' => $request->amount,
                'status' => 'pending',
            ]);
        }

        return redirect()->back()->with('success', 'Payments assigned to all students in the study plan successfully.');
    }

    public function assignPaymentToDormitory(Request $request)
    {
        $request->validate([
            'dormitory_id' => 'required|exists:dormitories,id',
            'type' => 'required',
            'amount' => 'required|numeric',
        ]);

        $students = Student::whereHas('accommodations', function ($query) use ($request) {
            $query->where('dormitory_id', $request->dormitory_id)
                ->where('status', 'active');
        })->get();

        foreach ($students as $student) {
            Payment::create([
                'student_id' => $student->id,
                'type' => $request->type,
                'amount' => $request->amount,
                'status' => 'pending',
            ]);
        }

        return redirect()->back()->with('success', 'Payments assigned to all students in the dormitory successfully.');
    }

    // app/Http/Controllers/PaymentController.php
    public function search(Request $request)
    {
        $query = $request->get('query', '');

        $students = Student::whereHas('user', function ($q) use ($query) {
            $q->where('first_name', 'LIKE', "%{$query}%")
                ->orWhere('last_name', 'LIKE', "%{$query}%");
        })
            ->orWhere('fn', 'LIKE', "%{$query}%")
            // ->orWhere('egn', 'LIKE', "%{$query}%")
            ->with('user')
            ->get();

        return response()->json($students);
    }
}
