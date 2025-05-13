<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MainTableController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\LeaderBoardController;
use App\Http\Controllers\StudentTaskController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceHistoryStatus;
use App\Http\Controllers\AttendanceHistoryController;
use App\Http\Controllers\StudentStatisticsController;
use App\Http\Controllers\StudentAnnouncementController;

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
//-----------------------------
Route::get('/', function () {
  return redirect('http://localhost:3000/');
})->name('landingPage');
//-----------------------------
// -------{Profile}---------- //
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// -------{Profile}---------- //
// 
// *****
###############{{ All }}################ 
// *****
//


// ###############{{ Students }}################ //
Route::middleware(['auth', 'role:student', 'verified'])->group(function () {
  Route::get('/student-dashboard', [StudentStatisticsController::class, 'index'])->name('studentDashboard');

// --{Student Tasks}-- //
 Route::get('/student/tasks', [StudentTaskController::class, 'index'])->name('studentSubmissions');
Route::get('/student/tasks/{taskId}', [StudentTaskController::class, 'show'])->name('studentSubmissions.show');
Route::post('/student/tasks/{taskId}/submit', [StudentTaskController::class, 'submitAnswer'])->name('studentSubmissions.submitAnswer');
// --{End Student Tasks}-- //


// --{Student Announcements}-- //
  Route::get('/student-announcements', [StudentAnnouncementController::class, 'index'])->name('announcements');
// --{End Student Announcements}-- //
});




// ###############{{ Admin,Trainer }}################ //
Route::middleware(['auth', 'role:admin,trainer', 'verified'])->group(function () {
  // -------{Main}---------- //

  Route::get('/dashboard', [StatisticsController::class, 'taskProgress'])->name('dashboard');
  // SUBS //
  Route::get('/tables', [MainTableController::class, 'index'])->name('tables');
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


  //------------ {{ Announcement }} --------------
Route::resource('announcements', AnnouncementController::class)->except(['show']);
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

  // -------{ Actions }---------- //
  Route::post('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
  Route::delete('users/{user}/delete-permanently', [UserController::class, 'deletePermanently'])->name('users.deletePermanently');

  // tasks
  Route::post('/tasks/{task}/restore', [TasksController::class, 'restore'])->name('tasks.restore');
  Route::delete('tasks/{task}/delete-permanently', [TasksController::class, 'deletePermanently'])->name('tasks.deletePermanently');
  Route::delete('/tasks/deleted/empty', [TasksController::class, 'emptyDeleted'])->name('tasks.emptyDeleted');


  // -------{ Actions }---------- //

});



require __DIR__ . '/auth.php';


  //  Route::post('attendanceHistory/lock-today', [AttendanceHistoryController::class, 'lockToday'])->name('attendance.lock');
 //   Route::post('attendanceHistory/unlock-today', [AttendanceHistoryController::class, 'unlockToday'])->name('attendance.unlock');
   //  Route::post('attendance/lock-today', [AttendanceController::class, 'lockToday'])->name('attendance.lock');
 //   Route::post('attendance/unlock-today', [AttendanceController::class, 'unlockToday'])->name('attendance.unlock');