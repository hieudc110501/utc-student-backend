<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TuitionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/getDB', [Controller::class, 'getDB']);

//post login
Route::get('/postLogin', [LoginController::class, 'postLogin']);

//
Route::get('/getSessionId', [LoginController::class, 'getSessionId']);
Route::get('/getCookie', [LoginController::class, 'getCookie']);
Route::get('/getHTML', [LoginController::class, 'getHTML']);

//controller
Route::get('/fetchData', [Controller::class, 'fetchData']);

//schedule
Route::get('/getAllSchedule', [ScheduleController::class, 'getAllSchedule']);
Route::get('/getExamSchedule', [ScheduleController::class, 'getExamSchedule']);
Route::get('/getScheduleByUsername/{id}', [ScheduleController::class, 'getScheduleByUsername']);

//student
Route::get('/getStudentByUsername/{username}', [StudentController::class, 'getStudentByUsername']);

//mark
Route::get('/getMark', [MarkController::class, 'getMark']);
Route::get('/getSubjectMark', [MarkController::class, 'getSubjectMark']);

//tuition
Route::get('/getTuitionPaid', [TuitionController::class, 'getTuitionPaid']);
Route::get('/getTuitionTotalDueAmount', [TuitionController::class, 'getTuitionTotalDueAmount']);
