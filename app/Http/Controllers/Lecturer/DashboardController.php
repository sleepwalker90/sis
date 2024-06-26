<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('lecturer.timetable');
    }

    public function editOfficeHours()
    {
        $lecturer = auth()->user()->lecturer;
        return view('lecturer.edit-office-hours', compact('lecturer'));
    }

    public function updateOfficeHours(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|string|in:Mon,Tue,Wed,Thu,Fri',
            'time_interval' => ['required','string','regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]-([0-1]?[0-9]|2[0-3]):[0-5][0-9]/'],
        ]);

        $lecturer = auth()->user()->lecturer;

        if (!$lecturer) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to update office hours.');
        }

        $officeHours = json_decode($lecturer->office_hours, true) ?? [];
        $officeHours[$request->day_of_week] = $request->time_interval;
        $lecturer->update(['office_hours' => json_encode($officeHours)]);

        return redirect()->route('lecturer.office-hours')->with('success', 'Office hours updated successfully.');
    }

    public function removeOfficeHour(Request $request)
    {
        $request->validate([
            'day' => 'required|string|in:Mon,Tue,Wed,Thu,Fri',
        ]);

        $lecturer = auth()->user()->lecturer;

        if (!$lecturer) {
            return redirect()->route('lecturer.office-hours')->with('error', 'You are not authorized to update office hours.');
        }

        $officeHours = json_decode($lecturer->office_hours, true) ?? [];
        unset($officeHours[$request->day]);
        $lecturer->update(['office_hours' => json_encode($officeHours)]);

        return redirect()->route('lecturer.office-hours')->with('success', 'Office hours removed successfully.');
    }
}
