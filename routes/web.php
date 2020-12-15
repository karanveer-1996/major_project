<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);
/**
 * Dashboard
 */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/**
 * Teacher 
 */
Route::resource('teacher', App\Http\Controllers\TeacherController::class);
/**
 * Course 
 */
Route::resource('course', App\Http\Controllers\CourseController::class);
/**
 * batch 
 */
Route::resource('schoolbatch', App\Http\Controllers\BatchController::class);
/**
 * Subjects 
 */
Route::resource('subjects', App\Http\Controllers\SubjectController::class);
/**
 * AssignTeacher 
 */
Route::resource('teacherAssign', App\Http\Controllers\AssignTeachersController::class);
/**
 * Student
 *  
 */
Route::resource('student', App\Http\Controllers\StudentController::class);
/**
 * Feedback 
 */
Route::resource('feedback', App\Http\Controllers\FeedbackController::class);
