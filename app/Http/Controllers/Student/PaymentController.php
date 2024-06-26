<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $pendingPayments = Payment::where('student_id', $student->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $paidPayments = Payment::where('student_id', $student->id)
            ->where('status', 'paid')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('student.payments.index', compact('pendingPayments', 'paidPayments'));
    }


    public function pay(Payment $payment)
    {
        return view('student.payments.pay', compact('payment'));
    }

    public function process(Request $request, Payment $payment)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $payment->amount * 100, // Amount in cents
                'currency' => 'bgn',
                'description' => 'Payment for ' . str_replace('_', ' ', $payment->type) . ' for ' . $payment->student->fn,
                'source' => $request->stripeToken,
            ]);

            $payment->update(['status' => 'paid']);

            return redirect()->route('student.payments.index')->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
