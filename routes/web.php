<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\TuitionController;
use Illuminate\Support\Facades\Route;

//login
Route::group(['prefix' => 'login'], function () {
    //post login
    Route::post('/postLogin', [LoginController::class, 'postLogin']);
});

//controller
Route::group(['prefix' => 'controller'], function () {
    //insert all
    Route::get('/insertAll', [Controller::class, 'insertAll']);
    //delete all
    Route::get('/deleteAll/{id}', [Controller::class, 'deleteAll']);
});

//student
Route::group(['prefix' => 'student'], function () {
    //insert student to database
    Route::post('/insert', [StudentController::class, 'insert']);
    //get student by id
    Route::get('/get/{id}', [StudentController::class, 'get']);
    //get student by id
    Route::get('/check/{id}', [StudentController::class, 'check']);
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
    //get exam schedule
    Route::post('/insertExam', [ScheduleController::class, 'insertExam']);
    //get exam schedule
    Route::get('/getExam/{id}', [ScheduleController::class, 'getExam']);
    //get exam schedule
    Route::delete('/deleteExam/{id}', [ScheduleController::class, 'deleteExam']);
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

//tuition
Route::group(['prefix' => 'tuition'], function () {
    //insert
    Route::post('/insert', [TuitionController::class, 'insert']);
    //get
    Route::get('/get/{id}', [TuitionController::class, 'get']);
    //insert
    Route::delete('/delete/{id}', [TuitionController::class, 'delete']);
});

//point
Route::group(['prefix' => 'point'], function () {
    //insert
    Route::post('/insert', [PointController::class, 'insert']);
    //get
    Route::get('/get/{id}', [PointController::class, 'get']);
    //insert
    Route::delete('/delete/{id}', [PointController::class, 'delete']);
});

//news
Route::group(['prefix' => 'news'], function () {
    //insert
    Route::post('/insert', [NewsController::class, 'insert']);
    //get
    Route::get('/get', [NewsController::class, 'get']);
    //insert
    Route::delete('/delete', [NewsController::class, 'delete']);
    //get
    Route::get('/getDetail', [NewsController::class, 'getDetail']);
});


Route::group(['prefix' => 'blog'], function () {
    //insert blog
    Route::post('/insert/{id}', [BlogController::class, 'insert']);
    //get all blog
    Route::get('/getAll', [BlogController::class, 'getAll']);
    //insert like
    Route::post('/insertLike/{id}', [BlogController::class, 'insertLike']);
    //delete like
    Route::post('/deleteLike', [BlogController::class, 'deleteLike']);
    //insert comment
    Route::post('/insertComment/{id}', [BlogController::class, 'insertComment']);
    //delete comment
    Route::delete('/deleteComment/{id}', [BlogController::class, 'deleteComment']);
    //get comment
    Route::get('/getComment/{id}', [BlogController::class, 'getComment']);
});
