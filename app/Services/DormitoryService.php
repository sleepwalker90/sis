<?php

namespace App\Services;

use App\Models\Dormitory;
use App\Models\DormitoryApplication;
use App\Models\Room;

class DormitoryService
{
    public function distibuteBeds()
    {
        $applicationsByMajor = DormitoryApplication::where('status', 'approved')
            ->with('student')
            ->get()
            ->groupBy('student.major_id');

        $rooms = Room::with('dormitory')->get();

        // Calculate proportional number of beds

        foreach ($applicationsByMajor as $majorId => $applications) {
            $totalBeds = $rooms->sum('beds');
            $proportianalBeds = intval(( $applications->count() / DormitoryApplication::where('academic_year', $this->getAcademicYear())) * $totalBeds);
        }
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