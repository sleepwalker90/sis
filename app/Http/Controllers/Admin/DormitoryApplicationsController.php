<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\DormitoryApplication;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DormitoryApplicationsController extends Controller
{
    public function index()
    {
        $pendingApplications = DormitoryApplication::where('status', 'pending')->with('student.user')->get();
        return view('admin.dormitory_applications.index', compact('pendingApplications'));
    }

    // Update application status
    public function update(Request $request, DormitoryApplication $application)
    {
        $request->validate([
            'status' => 'required|in:approved,denied'
        ]);

        $application->update($request->only('status'));

        return back()->with('success', 'Application status updated successfully.');
    }

    public function bulkApprove()
    {
        DB::beginTransaction();

        try {
            $applications = DormitoryApplication::where('status', 'pending')->with('student')->get();

            foreach ($applications as $application) {
                $application->update(['status' => 'approved']);
                $this->accommodateStudent($application->student);
            }

            DB::commit();
            return redirect()->back()->with('success', 'All pending applications have been approved and students accommodated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing the bulk approval: ' . $e->getMessage());
        }
    }

    protected function accommodateStudent(Student $student)
    {
        $room = Room::whereRaw('CAST(occupied_beds AS UNSIGNED) < CAST(beds AS UNSIGNED)')
            ->inRandomOrder()
            ->first();

        if ($room) {
            Accommodation::create([
                'student_id' => $student->id,
                'room_id' => $room->id,
                'dormitory_id' => $room->dormitory_id,
                'start_date' => now(),
                'status' => 'active',
            ]);

            $room->increment('occupied_beds');
        } else {
            // Log the error or handle it accordingly
            Log::error('No available rooms for student ID ' . $student->id . ': ' . $student->user->first_name . ' ' . $student->user->last_name . ' (' . $student->fn . ')');
        }
    }
}
