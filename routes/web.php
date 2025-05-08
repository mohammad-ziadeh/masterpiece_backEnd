<?php

use App\Models\Attendance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\LeaderBoardController;
use App\Http\Controllers\AttendanceHistoryStatus;
use App\Http\Controllers\AttendanceHistoryController;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------- 
| Web Routes
|--------------------------------------------------------------------------- 
| Here is where you can register web routes for your application.
| Routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "web" middleware group.
|
*/


// 
// *****
###############{{ All }}################ 
// *****
//
Route::get('/spinner', function () {
  return view('home.spinner');
})->name('spinner');

Route::get('/', function () {
  return redirect('http://localhost:3000/');
})->name('landingPage');
// 
// *****
###############{{ All }}################ 
// *****
//


// ###############{{ Students }}################ //
Route::middleware(['auth', 'role:student', 'verified'])->group(function () {
  Route::get('/student-dashboard', function () {
    return view('home.spinner');
  })->name('studentDashboard');
});




// ###############{{ Admin,Trainer }}################ //
Route::middleware(['auth', 'role:admin,trainer', 'verified'])->group(function () {
  // -------{Main}---------- //

  Route::get('/dashboard', [StatisticsController::class, 'taskProgress'])->name('dashboard');
  // SUBS //
  Route::view('/tables', 'admin.tables.main')->name('tables');
  // -------{Main}---------- //


  // -------{Tables}---------- //
  Route::resource('users', UserController::class);
  Route::get('/users/{user}/badges', [BadgeController::class, 'viewUserBadges'])->name('users.badges');
  Route::get('/users/{userId}/points', [UserController::class, 'showUserPoints'])->name('points');



  //------------ {{ Tasks }} --------------
  Route::resource('tasks', TasksController::class);
  //-------------------------------


  //------------ {{ Leaderboard }} --------------
  Route::resource('leaderBoard', LeaderBoardController::class);
  Route::get('/leaderboard/all', [LeaderboardController::class, 'full'])->name('leaderboard.full');
  Route::get('/leaderboard/lastWeek', [LeaderboardController::class, 'lastWeek'])->name('leaderboard.lastWeek');
  //-------------------------------


  //------------ {{ Badges }} --------------
  Route::get('/badges/assign', [BadgeController::class, 'assignForm'])->name('badges.assign.form');
  Route::post('/badges/assign', [BadgeController::class, 'assign'])->name('badges.assign');
  Route::get('/badges/create', [BadgeController::class, 'create'])->name('badges.create');
  Route::post('/badges/store', [BadgeController::class, 'store'])->name('badges.store');
  Route::delete('/badges/{badge}', [BadgeController::class, 'destroy'])->name('badges.destroy');
  //-------------------------------

  //------------ {{ Submissions }} --------------
  Route::resource('submissions', SubmissionController::class);
  Route::post('/submissions/update-grade', [SubmissionController::class, 'updateGrade'])->name('submissions.update.grade');
  //-------------------------------


  Route::resource('attendance', AttendanceController::class);
  Route::get('attendance/{userId}/history', [AttendanceController::class, 'showHistory'])->name('attendance.history');
  // -------{{ All Attendance History }}------- //
  Route::resource('attendanceHistory', AttendanceHistoryController::class);
  Route::get('attendanceHistory/{userId}/history', [AttendanceController::class, 'showHistory'])->name('attendance.history');

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


  //  Route::post('attendanceHistory/lock-today', [AttendanceHistoryController::class, 'lockToday'])->name('attendance.lock');
 //   Route::post('attendanceHistory/unlock-today', [AttendanceHistoryController::class, 'unlockToday'])->name('attendance.unlock');
   //  Route::post('attendance/lock-today', [AttendanceController::class, 'lockToday'])->name('attendance.lock');
 //   Route::post('attendance/unlock-today', [AttendanceController::class, 'unlockToday'])->name('attendance.unlock');