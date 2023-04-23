<?php

use App\Http\Controllers\MarkController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TermController;
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
    //insert schedule to database
    Route::post('/insert', [ScheduleController::class, 'insert']);
    //get schedule by id
    Route::get('/get/{id}', [ScheduleController::class, 'get']);
    //delete
    Route::delete('/delete/{id}', [ScheduleController::class, 'delete']);
});

//term
Route::group(['prefix' => 'term'], function () {
    //insert term to database
    Route::post('/insert/{id}', [TermController::class, 'insert']);
    //get term by id
    Route::get('/get/{id}', [TermController::class, 'get']);
    //delete
    Route::delete('/delete/{id}', [TermController::class, 'delete']);
});


//mark
Route::group(['prefix' => 'mark'], function () {
    //insert mark to database
    Route::post('/insertGPA', [MarkController::class, 'insertGPA']);
    //insert all mark to database
    Route::post('/insertAll', [MarkController::class, 'insertAll']);
    //get mark by id
    Route::get('/getAll/{id}', [MarkController::class, 'getAll']);
    //delete
    Route::delete('/deleteAll/{id}', [MarkController::class, 'deleteAll']);
    //get mark term
    Route::post('/insertMarkTerm', [MarkController::class, 'insertMarkTerm']);
    //get term
    Route::post('/getTerm', [MarkController::class, 'getTerm']);
    //get mark by term
    Route::get('/getMarkByTerm', [MarkController::class, 'getMarkByTerm']);
    //get all term by id
    Route::get('/getAllTerm/{id}', [MarkController::class, 'getAllTerm']);
    //get gpa
    Route::get('/getGPA/{id}', [MarkController::class, 'getGPA']);
});
