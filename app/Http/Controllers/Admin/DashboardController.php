<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tiles = [
            ['title' => 'Admins', 'icon' => 'fas fa-users', 'route' => 'admin.users'],
            ['title' => 'Students', 'icon' => 'fas fa-user-graduate', 'route' => 'admin.students.index'],
            ['title' => 'Lecturers', 'icon' => 'fas fa-chalkboard-teacher', 'route' => 'admin.lecturers.index'],
            ['title' => 'Faculties', 'icon' => 'fas fa-university', 'route' => 'admin.faculties'],
            ['title' => 'Majors', 'icon' => 'fas fa-book', 'route' => 'admin.majors'],
            ['title' => 'Study Plans', 'icon' => 'fas fa-file-alt', 'route' => 'admin.studyplans.index'],
            ['title' => 'Courses', 'icon' => 'fas fa-book-open', 'route' => 'admin.courses'],
            ['title' => 'Streams', 'icon' => 'fas fa-stream', 'route' => 'admin.streams.index'],
            ['title' => 'Groups', 'icon' => 'fas fa-users-cog', 'route' => 'admin.groups.index'],
            ['title' => 'Scholarships', 'icon' => 'fas fa-hand-holding-usd', 'route' => 'admin.scholarships.index'],
            ['title' => 'Dormitories', 'icon' => 'fas fa-bed', 'route' => 'admin.dormitories.index'],
            ['title' => 'Academic Years', 'icon' => 'fas fa-calendar-alt', 'route' => 'admin.academic-years.index'],
            ['title' => 'Payments', 'icon' => 'fas fa-dollar-sign', 'route' => 'admin.payments.index'],
        ];

        return view('admin.dashboard', compact('tiles'));
    }
}
