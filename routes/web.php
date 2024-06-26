<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\CourseAssignmentController;
use App\Http\Controllers\Admin\CourseScheduleController;
use App\Http\Controllers\Admin\DormitoryApplicationsController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ScholarshipController;
use App\Http\Controllers\Admin\DormitoryController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Lecturer;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student;
use App\Http\Controllers\Teacher;
use App\Http\Controllers\DormitoryApplicationController;
use App\Http\Controllers\Admin\StreamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\LanguageController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route(auth()->check() ? auth()->user()->getRedirectRouteName() : 'login');
});

# TO DO Fix profile views
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:Student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('timetable', [Student\TimetableController::class, 'index'])
            ->name('timetable');
        Route::get('dashboard', [Student\DashboardController::class, 'showGeneralInfo'])
            ->name('dashboard');
        Route::get('courses', [Student\DashboardController::class, 'showCourses'])
            ->name('courses');
        Route::get('student/courses/{course}/lecturer', [Student\DashboardController::class, 'showCourseLecturer'])
            ->name('courses.lecturer');
        Route::get('scholarship', [Student\DashboardController::class, 'showScholarshipStatus'])
            ->name('scholarship');
        Route::post('scholarship', [Student\DashboardController::class, 'applyForScholarship'])
            ->name('scholarship.apply');
    });

Route::middleware(['auth', 'verified', 'role:Teacher'])
    ->prefix('lecturer')
    ->name('lecturer.')
    ->group(function () {
        Route::get('timetable', [Lecturer\TimetableController::class, 'index'])
            ->name('timetable');
        Route::get('office-hours', [Lecturer\DashboardController::class, 'editOfficeHours'])->name('office-hours');
        Route::post('office-hours', [Lecturer\DashboardController::class, 'updateOfficeHours'])->name('update-office-hours');
        Route::post('office-hours/remove', [Lecturer\DashboardController::class, 'removeOfficeHour'])->name('remove-office-hours');
    });

Route::middleware(['auth', 'verified', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [Admin\DashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('users/create', [Admin\UsersController::class, 'create'])
            ->name('users.create');
        Route::post('users/create', [Admin\UsersController::class, 'store']);
        Route::get('users', [Admin\UsersController::class, 'index'])
            ->name('users');
        Route::get('users/{user}/edit', [Admin\UsersController::class, 'edit'])
            ->name('users.edit');
        Route::patch('users/{user}', [Admin\UsersController::class, 'update'])
            ->name('users.update');
        Route::delete('users/{user}', [Admin\UsersController::class, 'destroy'])
            ->name('users.destroy');
    });

Route::middleware(['auth', 'verified', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('scholarships', [ScholarshipController::class, 'index'])
            ->name('scholarships.index');
        Route::delete('scholarships/{scholarship}', [ScholarshipController::class, 'destroy'])
            ->name('scholarships.destroy');
        Route::patch('scholarships', [ScholarshipController::class, 'update'])
            ->name('scholarships.update');
    });

Route::get('/last-logins', function () {
    $user = auth()->user();
    $loginRecords = $user->loginRecords()->latest()->take(10)->get();
    return view('last-logins', compact('loginRecords'));
})->middleware('auth')->name('last-logins');

Route::resource('courses', Admin\CourseController::class)
    ->middleware(['auth', 'verified', 'permission:create_course'])
    ->names([
        'index' => 'admin.courses',
        'create' => 'admin.courses.create',
        'store' => 'admin.courses.store',
        'show' => 'admin.courses.show',
    ]);

Route::resource('majors', Admin\MajorController::class)
    ->middleware(['auth', 'verified', 'role:Admin'])
    ->names([
        'index' => 'admin.majors',
        'create' => 'admin.majors.create',
        'store' => 'admin.majors.store',
        'edit' => 'admin.majors.edit',
        'update' => 'admin.majors.update',
        'show' => 'admin.majors.show'
    ]);

Route::resource('faculties', Admin\FacultyController::class)
    ->middleware(['auth', 'verified', 'role:Admin'])
    ->names([
        'index' => 'admin.faculties',
        'create' => 'admin.faculties.create',
        'store' => 'admin.faculties.store',
        'edit' => 'admin.faculties.edit',
        'update' => 'admin.faculties.update',
    ]);

Route::middleware(['auth', 'verified', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('studyplans', Admin\StudyPlanController::class);
    });

// Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
//     Route::resource('course-schedules', CourseScheduleController::class)->only(['index', 'create','store', 'destroy']);
// });

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/admin/course-schedules/create/{courseLecturerAssignment}', [CourseScheduleController::class, 'create'])->name('course_schedules.create');
    Route::post('/admin/course-schedules', [CourseScheduleController::class, 'store'])->name('course_schedules.store');
    Route::delete('/admin/course-schedules/{courseSchedule}', [CourseScheduleController::class, 'destroy'])->name('course_schedules.destroy');
});



Route::middleware(['auth', 'verified', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::delete('studyplans/{studyPlan}/courses/{course}', [Admin\StudyPlanCoursesController::class, 'detachCourse'])
            ->name('studyplans.courses.detach');
        Route::get('studyplans/{studyPlan}/courses/attach', [Admin\StudyPlanCoursesController::class, 'showAttachCoursesForm'])
            ->name('studyplans.courses.attach.form');
        Route::post('studyplans/{studyPlan}/courses/attach', [Admin\StudyPlanCoursesController::class, 'attachCourse'])
            ->name('studyplans.courses.attach');
    });

Route::post('/toggle-registration', function (Request $request) {
    $status = $request->input('status') === true; // Expecting a string 'true' or 'false'

    // Update the setting in the database. Convert boolean to 'true'/'false' string.
    DB::table('settings')->where('key', 'disable_registration')->update(['value' => $status ? 'true' : 'false']);

    return response()->json(['success' => true, 'status' => $status]);
})->middleware(['auth']); // Ensure only authenticated users can access this endpoint.

Route::post('/admin/toggle-registration', [RegistrationController::class, 'toggleRegistration'])->middleware('auth', 'role:3')->name('admin.toggleRegistration');

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('dormitories', DormitoryController::class)->except(['show']);
    Route::resource('dormitory_application_periods', Admin\DormitoryApplicationPeriodController::class)->except(['show']);
    Route::resource('rooms', RoomController::class)->only(['store', 'update', 'destroy']);
    Route::post('rooms/assign-student', [RoomController::class, 'assignStudent'])->name('rooms.assignStudent');
});

Route::middleware(['auth', 'verified', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::patch('accommodations/{accommodation}', [Admin\AccommodationController::class, 'update'])->name('accommodations.update');
        Route::post('accommodations/assign', [Admin\AccommodationController::class, 'assignStudent'])->name('accommodations.assign');
        Route::get('dormitory-applications/pending', [DormitoryApplicationsController::class, 'index'])->name('dormitory-applications.pending');
        Route::patch('dormitory-applications/{application}', [DormitoryApplicationsController::class, 'update'])->name('dormitory-applications.update');
        Route::post('dormitory-applications/bulk-approve', [DormitoryApplicationsController::class, 'bulkApprove'])->name('dormitory-applications.bulk-approve');
    });


Route::middleware(['auth', 'role:Student'])->prefix('student')->name('student.')->group(function () {
    Route::resource('dormitories', Student\DomritoryController::class)->except(['show']);
});

Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::resource('dormitory_applications', Student\DormitoryApplicationController::class)->only(['create', 'store']);
});

Route::prefix('admin')->middleware(['auth', 'role:Admin'])->name('admin.')->group(function () {
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/create', [AdminPaymentController::class, 'create'])->name('payments.create');
    Route::post('payments', [AdminPaymentController::class, 'store'])->name('payments.store');
    Route::delete('payments/{payment}', [AdminPaymentController::class, 'destroy'])->name('payments.destroy');
    Route::get('/admin/payments/search', [AdminPaymentController::class, 'search'])->name('payments.search');
    Route::resource('lecturers', LecturerController::class)->except(['show']);
    Route::resource('students', Admin\StudentController::class)->except(['show']);
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Course assignment routes
    Route::get('course-assignments', [CourseAssignmentController::class, 'show'])->name('course-assignments.show');
    Route::post('course-assignments', [CourseAssignmentController::class, 'assign'])->name('course-assignments.assign');
    Route::delete('course-assignments/{assignment}', [CourseAssignmentController::class, 'unassign'])->name('course-assignments.unassign');
});

// Student routes
Route::middleware(['auth', 'role:Student'])->prefix('student')->name('student.')->group(function () {
    Route::get('payments', [App\Http\Controllers\Student\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}/pay', [App\Http\Controllers\Student\PaymentController::class, 'pay'])->name('payments.pay');
    Route::post('payments/{payment}/process', [App\Http\Controllers\Student\PaymentController::class, 'process'])->name('payments.process');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('academic-years', AcademicYearController::class);
});

Route::prefix('lecturer')->name('lecturer.')->middleware(['auth', 'role:Teacher'])->group(function () {
    Route::get('attestations', [Lecturer\AttestationController::class, 'index'])->name('attestations.index');
    Route::get('attestations/{assignment}', [Lecturer\AttestationController::class, 'show'])->name('attestations.show');
    Route::post('attestations/{assignment}', [Lecturer\AttestationController::class, 'store'])->name('attestations.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('attestations/{assignment}', [Admin\AttestationController::class, 'show'])->name('attestations.show');
    Route::post('attestations/{assignment}', [Admin\AttestationController::class, 'store'])->name('attestations.store');
});

Route::prefix('lecturer')->name('lecturer.')->middleware(['auth', 'role:Teacher'])->group(function () {
    Route::get('marks/{assignment}', [Lecturer\MarkController::class, 'show'])->name('marks.show');
    Route::post('marks/{assignment}', [Lecturer\MarkController::class, 'store'])->name('marks.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('marks/{assignment}', [Admin\MarkController::class, 'show'])->name('marks.show');
    Route::post('marks/{assignment}', [Admin\MarkController::class, 'store'])->name('marks.store');
});




Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('streams', StreamController::class);
    Route::resource('groups', GroupController::class);
    Route::get('/groups/{group}/add-student', [GroupController::class, 'addStudents'])->name('groups.addStudent');
    Route::post('/groups/{group}/store-student', [GroupController::class, 'storeStudents'])->name('groups.storeStudent');
});

Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');


require __DIR__ . '/auth.php';
