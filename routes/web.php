<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceHistoryStatus;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use App\Models\Attendance;

/*
|--------------------------------------------------------------------------- 
| Web Routes
|--------------------------------------------------------------------------- 
| Here is where you can register web routes for your application.
| Routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "web" middleware group.
|
*/


// ###############{{ Trainer }}################ //
Route::middleware(['auth', 'verified', 'role:trainer'])->group(function () {
    // -------{Main}---------- //
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    // SUBS //
    Route::view('/tables', 'tables.main')->name('tables');
    // -------{Main}---------- //


    // -------{Tables}---------- //
    Route::resource('users', UserController::class);
    Route::resource('tasks', TasksController::class);
    //----------------------------
    Route::resource('attendance', AttendanceController::class);
    Route::post('attendance/lock-today', [AttendanceController::class, 'lockToday'])->name('attendance.lock');
    Route::post('attendance/unlock-today', [AttendanceController::class, 'unlockToday'])->name('attendance.unlock');
    Route::get('attendance/{userId}/history', [AttendanceController::class, 'showHistory'])->name('attendance.history');


    // -------{ Actions }---------- //
    Route::post('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{user}/delete-permanently', [UserController::class, 'deletePermanently'])->name('users.deletePermanently');
    // tasks
    Route::post('/tasks/{task}/restore', [TasksController::class, 'restore'])->name('tasks.restore');
    Route::delete('tasks/{task}/delete-permanently', [TasksController::class, 'deletePermanently'])->name('tasks.deletePermanently');
    Route::delete('/tasks/deleted/empty', [TasksController::class, 'emptyDeleted'])->name('tasks.emptyDeleted');

    // -------{ Actions }---------- //


    // -------{Profile}---------- //
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // -------{Profile}---------- //
});



// ###############{{ Admin }}################ //
Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    // -------{Main}---------- //
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    // SUBS //
    Route::view('/tables', 'tables.main')->name('tables');
    // -------{Main}---------- //


    // -------{Tables}---------- //
    Route::resource('users', UserController::class);
    Route::resource('tasks', TasksController::class);
    //-------------------------------
    Route::resource('attendance', AttendanceController::class);
    Route::post('attendance/lock-today', [AttendanceController::class, 'lockToday'])->name('attendance.lock');
    Route::post('attendance/unlock-today', [AttendanceController::class, 'unlockToday'])->name('attendance.unlock');
    Route::get('attendance/{userId}/history', [AttendanceController::class, 'showHistory'])->name('attendance.history');


    // -------{ Actions }---------- //
    Route::post('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{user}/delete-permanently', [UserController::class, 'deletePermanently'])->name('users.deletePermanently');

    // tasks
    Route::post('/tasks/{task}/restore', [TasksController::class, 'restore'])->name('tasks.restore');
    Route::delete('tasks/{task}/delete-permanently', [TasksController::class, 'deletePermanently'])->name('tasks.deletePermanently');
    Route::delete('/tasks/deleted/empty', [TasksController::class, 'emptyDeleted'])->name('tasks.emptyDeleted');


    // -------{ Actions }---------- //


    // -------{Profile}---------- //
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // -------{Profile}---------- //
});



require __DIR__ . '/auth.php';
