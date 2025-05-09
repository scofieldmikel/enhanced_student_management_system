<?php

use App\Http\Controllers\RoleAssign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\StudentGradeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/profile', [HomeController::class, 'profile'])->middleware('auth')->name('profile');
Route::get('/profile/edit', [HomeController::class, 'profileEdit'])->middleware('auth')->name('profile.edit');
Route::put('/profile/update', [HomeController::class, 'profileUpdate'])->middleware('auth')->name('profile.update');
Route::get('/profile/changepassword', [HomeController::class, 'changePasswordForm'])->middleware('auth')->name('profile.change.password');
Route::post('/profile/changepassword', [HomeController::class, 'changePassword'])->middleware('auth')->name('profile.changepassword');

Route::group(['middleware' => ['auth','role:Admin']], function ()
{
    Route::get('/roles-permissions', [RolePermissionController::class, 'roles'])->name('roles-permissions');
    Route::get('/roles-create', [RolePermissionController::class, 'createRole'])->name('role.create');
    Route::post('/roles-store', [RolePermissionController::class, 'storeRole'])->name('role.store');
    Route::get('/roles-edit/{id}', [RolePermissionController::class, 'editRole'])->name('role.edit');
    Route::put('/roles-update/{id}', [RolePermissionController::class, 'updateRole'])->name('role.update');

    Route::get('/permission-create', [RolePermissionController::class, 'createPermission'])->name('permission.create');
    Route::post('/permission-store', [RolePermissionController::class, 'storePermission'])->name('permission.store');
    Route::get('/permission-edit/{id}', [RolePermissionController::class, 'editPermission'])->name('permission.edit');
    Route::put('/permission-update/{id}', [RolePermissionController::class, 'updatePermission'])->name('permission.update');

    Route::get('assign-subject-to-class/{id}', [GradeController::class, 'assignSubject'])->name('class.assign.subject');
    Route::post('assign-subject-to-class/{id}', [GradeController::class, 'storeAssignedSubject'])->name('store.class.assign.subject');

    Route::resource('assignrole', RoleAssign::class);
    Route::resource('classes', GradeController::class);
    Route::resource('subject', SubjectController::class);

    Route::resource('teacher', TeacherController::class);
    Route::resource('parents', ParentsController::class);
    Route::resource('student', StudentController::class);

    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');

});

Route::group(['middleware' => ['auth','role:Teacher']], function ()
{
    Route::post('attendance', [AttendanceController::class, 'store'])->name('teacher.attendance.store');
    Route::get('attendance-create/{classid}', [AttendanceController::class, 'createByTeacher'])->name('teacher.attendance.create');

    Route::post('store', [StudentGradeController::class, 'store'])->name('student.grade.store');
    Route::get('create', [StudentGradeController::class, 'create'])->name('student.grade.create');
    Route::get('student-grade', [StudentGradeController::class, 'index'])->name('student.grade.index');

});

Route::group(['middleware' => ['auth','role:Parent']], function ()
{
    Route::get('/attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
});

Route::group(['middleware' => ['auth','role:Student']], function () {

});