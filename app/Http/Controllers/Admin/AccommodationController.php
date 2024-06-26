<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Dormitory;
use App\Models\DormitoryApplication;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    public function assignStudent(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'student_id' => 'required|exists:students,id',
        ]);

        $room = Room::find($request->room_id);
        $student = Student::findOrFail($request->student_id);

        $currentYear = now()->year;
        $academicYear = now()->month >= 9 ? $currentYear . '/' . ($currentYear + 1) : ($currentYear - 1) . '/' . $currentYear;
        $approvedApplication = DormitoryApplication::where('student_id', $student->id)
            ->where('status', 'approved')
            ->where('academic_year', $academicYear)
            ->first();

        if (!$approvedApplication) {
            return redirect()->route('admin.dormitories.edit', ['dormitory' => $room->dormitory_id])
                ->with('error', 'Student does not have an approved dormitory application for the current academic year.');
        }

        $existingAccommodation = Accommodation::where('student_id', $student->id)
            ->where('status', 'active')
            ->first();

        if ($existingAccommodation) {
            return redirect()->route('admin.dormitories.edit', ['dormitory' => $room->dormitory_id])
                ->with('success', 'Student is already accommodated in a room.');
        }

        if ($room->occupied_beds < $room->beds) {
            Accommodation::create([
                'student_id' => $request->student_id,
                'room_id' => $room->id,
                'dormitory_id' => $room->dormitory_id,
                'start_date' => now(),
                'status' => 'active',
            ]);

            $room->occupied_beds += 1;
            $room->save();

            return redirect()->route('admin.dormitories.edit', ['dormitory' => $room->dormitory_id])->with('success', 'Student assigned successfully.');
        } else {
            return redirect()->route('admin.dormitories.edit', ['dormitory' => $room->dormitory_id])->with('error', 'No available beds in this room.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,left,evicted',
        ]);

        $accommodation = Accommodation::findOrFail($id);
        $room = Room::find($accommodation->room_id);
        $accommodation->status = $request->status;
        $accommodation->end_date = now();
        $accommodation->save();
        $room->occupied_beds -= 1;
        $room->save();

        return back()->with('success', 'Accommodation status updated successfully.');
    }
}
