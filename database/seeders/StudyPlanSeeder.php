<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Major;
use App\Models\StudyPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academic_years = AcademicYear::all();
        $majors = Major::all();
        foreach ($academic_years as $academic_year) {
            foreach ($majors as $major) {
                StudyPlan::create([
                    'title' => $major->name . ' ' . $academic_year->year,
                    'academic_year_id' => $academic_year->id,
                    'major_id' => $major->id
                ]);
            }
        }
        
        $studyPlans = StudyPlan::where('major_id', 16)->orderBy('created_at', 'desc')->get();
        $courseCodesBySemester = [
            ['MAT13','PHY03','CCE01','ENG01','LNG11','SPR01'],
            ['MAT22','ENG05','CCE02','EEA24','LNG12','PRC01','SPR02'],
            ['MAT33','EEA25','MEC24','CCE03','CCE04','SPR03'],
            ['CCE05','CCE06','CCE07','CCE08','EEA26','CCE09','PRC02','SPR04'],
            ['BCSE01','BCSE02','BCSE03','BCSE04','BCSE05','BCSE06','BCSE07'],
            ['BCSE08','BCSE09','BCSE10','BCSE11','BCSE12','BCSE13','BCSE14'],
            ['BCSE15','BCSE16'],
            ['BCSE26']
        ];
        
        foreach ($studyPlans as $studyPlan) {
            $semester = 1;
            foreach ($courseCodesBySemester as $courseCodes) {
                $courses = Course::whereIn('code',$courseCodes)->get();
                foreach ($courses as $course) {
                    $studyPlan->courses()->attach($course->id, ['semester' => $semester]);
                }
                $semester++;
            }
        }
        
        
        
    }
}
