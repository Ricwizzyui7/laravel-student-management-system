<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\IdCardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\AdminSettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


// 1. Welcome Page (Automatically direct to the app)
Route::get('/', function () {
    return redirect('/dashboard');
});

// 2. Dashboard Route
Route::get('/dashboard', [StudentController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

// 3. Authenticated Routes
Route::middleware('auth')->group(function () {

    // User Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // In-app Notifications (each user sees their own)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::post('/notifications/clear', [NotificationController::class, 'clear'])->name('notifications.clear');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // User Settings (all authenticated users)
    Route::prefix('settings/user')->group(function () {
        Route::get('/', [UserSettingsController::class, 'index'])->name('settings.user.index');
        Route::post('/profile-picture', [UserSettingsController::class, 'updateProfilePicture'])->name('settings.user.profile-picture');
        Route::post('/password', [UserSettingsController::class, 'updatePassword'])->name('settings.user.password');
        Route::post('/email', [UserSettingsController::class, 'updateEmail'])->name('settings.user.email');
        Route::post('/theme', [UserSettingsController::class, 'updateTheme'])->name('settings.user.theme');
        Route::post('/language', [UserSettingsController::class, 'updateLanguage'])->name('settings.user.language');
        Route::post('/notifications', [UserSettingsController::class, 'updateNotificationPreferences'])->name('settings.user.notifications');
    });

    // Admin Settings (admins only)
    Route::prefix('settings/admin')->middleware('auth')->group(function () {
        Route::get('/', [AdminSettingsController::class, 'index'])->name('settings.admin.index');
        Route::post('/system-name', [AdminSettingsController::class, 'updateSystemName'])->name('settings.admin.system-name');
        Route::post('/institution', [AdminSettingsController::class, 'updateInstitution'])->name('settings.admin.institution');
        Route::post('/logo', [AdminSettingsController::class, 'updateLogo'])->name('settings.admin.logo');
        Route::post('/contact', [AdminSettingsController::class, 'updateContact'])->name('settings.admin.contact');
        Route::post('/academic-year', [AdminSettingsController::class, 'updateAcademicYear'])->name('settings.admin.academic-year');
    });

    // 👥 STAFF & ADMIN ACCESS: View Student List
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');

    /*
     |--------------------------------------------------------------------
     | Course Management Module
     |--------------------------------------------------------------------
     | Listing + detail are viewable by any authenticated user; creating,
     | editing and deleting courses are admin-only.
     */
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

    Route::middleware('admin')->group(function () {
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
    });

    /*
     |--------------------------------------------------------------------
     | PDF Report Module (admin only)
     |--------------------------------------------------------------------
     */
    Route::middleware('admin')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/students', [ReportController::class, 'studentList'])->name('reports.students');
        Route::get('/reports/students/{id}', [ReportController::class, 'studentProfile'])->name('reports.student');
        Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
        Route::get('/reports/courses', [ReportController::class, 'courses'])->name('reports.courses');
        Route::get('/reports/departments', [ReportController::class, 'departments'])->name('reports.departments');
    });

    /*
     |--------------------------------------------------------------------
     | Excel Export Module (admin only)
     |--------------------------------------------------------------------
     */
    Route::middleware('admin')->group(function () {
        Route::get('/exports', [ExportController::class, 'index'])->name('exports.index');
        Route::get('/exports/students', [ExportController::class, 'students'])->name('exports.students');
        Route::get('/exports/courses', [ExportController::class, 'courses'])->name('exports.courses');
        Route::get('/exports/departments', [ExportController::class, 'departments'])->name('exports.departments');
        Route::get('/exports/attendance', [ExportController::class, 'attendance'])->name('exports.attendance');
    });

    // Wildcard course detail at the bottom of the course group.
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

    /*
     |--------------------------------------------------------------------
     | Attendance Management Module
     |--------------------------------------------------------------------
     | Dashboard entry point is available to everyone: admins see the full
     | dashboard; a linked student is redirected to their own profile.
     */
    Route::get('/attendance', [AttendanceController::class, 'dashboard'])->name('attendance.dashboard');

    // Student attendance profile — controller enforces owner-or-admin access.
    Route::get('/attendance/student/{id}', [AttendanceController::class, 'student'])->name('attendance.student');

    // Admin-only attendance operations.
    Route::middleware('admin')->group(function () {
        Route::get('/attendance/mark', [AttendanceController::class, 'markForm'])->name('attendance.mark');
        Route::post('/attendance/mark', [AttendanceController::class, 'markStore'])->name('attendance.mark.store');
        Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
        Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
    });

    // 🧪 TEMPORARY DIAGNOSTIC: Commented out 'admin' middleware to check for 500 root cause
    // 🔐 ADMIN ONLY ACCESS (Now protected by our fixed, safe middleware)
    Route::middleware('admin')->group(function () {
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

        // Attendance management (admin only)
        Route::post('/students/{id}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::delete('/students/{id}/attendance/{attendanceId}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    });

    // Student ID card — controller enforces owner-or-admin access.
    Route::get('/students/{id}/id-card', [IdCardController::class, 'show'])->name('students.idcard');

    // 👥 Wildcard route at the bottom
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
});

// Load auth routes
require __DIR__.'/auth.php';