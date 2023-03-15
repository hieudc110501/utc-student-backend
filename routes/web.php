<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getSessionId', [LoginController::class, 'getSessionId']);
Route::get('/getCookie', [LoginController::class, 'getCookie']);
Route::get('/getHTML', [LoginController::class, 'getHTML']);

Route::get('/getAllSchedule', [ScheduleController::class, 'getAllSchedule']);

Route::get('/getStudent', [StudentController::class, 'getStudent']);
