<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dormitory;
use App\Models\Student;
use Illuminate\Http\Request;

class DormitoryController extends Controller
{
    public function index()
    {
        $dormitories = Dormitory::with('rooms')->get();

        return view('admin.dormitory.index', compact('dormitories'));
    }

    public function create()
    {
        return view('admin.dormitory.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'building' => ['required', 'string', 'max:255', 'unique:dormitories'],
        ]);
        Dormitory::create($attributes);

        return redirect()->route('admin.dormitories.index')->with('success', 'Dormitory created successfully!');
    }

    public function edit(Dormitory $dormitory)
    {
        $academicYear = getCurrentAcademicYear();

        // Fetch students with approved applications for the current academic year and not currently accommodated
        $students = Student::whereHas('dormitoryApplications', function ($query) use ($academicYear) {
            $query->where('status', 'approved')->where('academic_year', $academicYear);
        })
            ->whereDoesntHave('accommodations', function ($query) {
                $query->where('status', 'active');
            })
            ->with('user')
            ->get();

        return view('admin.dormitory.edit', [
            'dormitory' => $dormitory,
            'students' => $students,
        ]);
    }



    public function update(Request $request, Dormitory $dormitory)
    {
        $attributes = $request->validate([
            'building' => ['required', 'string', 'max:255', 'unique:dormitories'],
        ]);
        $dormitory->update($attributes);
        return redirect()->route('admin.dormitories.index')->with('success', 'Dormitory updated successfully!');
    }

    public function destroy(Dormitory $dormitory)
    {
        $dormitory->delete();
        return redirect()->route('admin.dormitories.index')->with('success', 'Dormitory deleted successfully!');
    }
}
