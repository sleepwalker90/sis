<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DormitoryApplicationPeriod;
use Illuminate\Http\Request;

class DormitoryApplicationPeriodController extends Controller
{
    public function index()
    {
        $periods = DormitoryApplicationPeriod::all();
        return view('admin.dormitory_application_period.index', compact('periods'));
    }

    public function create()
    {
        return view('admin.dormitory_application_period.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        DormitoryApplicationPeriod::create($validated);

        return redirect()->route('admin.dormitory_application_period.index')->with('success', 'Period created successfully');
    }

    public function edit(DormitoryApplicationPeriod $period)
    {
        return view('admin.dormitory_application_period.edit', compact('period'));
    }

    public function update(Request $request, DormitoryApplicationPeriod $period)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $period->update($validated);
        return redirect()->route('admin.dormitory_application_period.index')->with('success', 'Period updated successfully');
    }

    public function destroy(DormitoryApplicationPeriod $period)
    {
        $period->delete();
        return redirect()->route('admin.dormitory_application_period.index')->with('success', 'Dormitory application period deleted successfully');
    }
}
