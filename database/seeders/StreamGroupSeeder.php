<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudyPlan;
use App\Models\Stream;
use App\Models\Group;
use App\Models\AcademicYear;

class StreamGroupSeeder extends Seeder
{
    public function run()
    {
        $academicYears = AcademicYear::all();
         // Only for major_id 16

        foreach ($academicYears as $academicYear) {
            $streamNumber = 1;
            $studyPlans = StudyPlan::where('major_id', 16)->where('academic_year_id', $academicYear->id)->get();
            foreach ($studyPlans as $studyPlan) {
                
                for ($i = 0; $i < 2; $i++) { // 2 streams per study plan per academic year
                    $stream = Stream::create([
                        'number' => $streamNumber,
                        'study_plan_id' => $studyPlan->id,
                        'academic_year_id' => $academicYear->id,
                    ]);

                    $groupNumber = ($streamNumber - 1) * 3 + 1; // Start group numbers from 1 for each stream
                    for ($j = 0; $j < 3; $j++) { // 3 groups per stream
                        Group::create([
                            'number' => $groupNumber,
                            'stream_id' => $stream->id,
                            'academic_year_id' => $academicYear->id,
                        ]);
                        $groupNumber++;
                    }

                    $streamNumber++;
                }
            }
        }
    }
}

