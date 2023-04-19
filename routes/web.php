<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\TuitionController;
use Illuminate\Support\Facades\Route;

//student
Route::group(['prefix' => 'student'], function () {
    //insert student to database
    Route::post('/insert', [StudentController::class, 'insert']);
    //get student by id
    Route::get('/get/{id}', [StudentController::class, 'get']);
    //delete
    Route::delete('/delete/{id}', [StudentController::class, 'delete']);
});

//schedule
Route::group(['prefix' => 'schedule'], function () {
    //insert student to database
    Route::post('/insert', [ScheduleController::class, 'insert']);
    //get student by id
    Route::get('/get/{id}', [ScheduleController::class, 'get']);
    //delete
    Route::delete('/delete/{id}', [ScheduleController::class, 'delete']);
});

//term
Route::group(['prefix' => 'term'], function () {
    //insert student to database
    Route::post('/insert/{id}', [TermController::class, 'insert']);
    //get student by id
    Route::get('/get/{id}', [TermController::class, 'get']);
    //delete
    Route::delete('/delete/{id}', [TermController::class, 'delete']);
});
