<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//api register
Route::post('register', 'App\Http\Controllers\api\RegisterController@register');
Route::post('login', 'App\Http\Controllers\api\LoginController@login');
Route::delete('logout', 'App\Http\Controllers\api\LoginController@logout');
Route::post('refresh-token', 'App\Http\Controllers\api\LoginController@refresh_token');


//người dùng
Route::group(['prefix' => 'user'], function () {
    //thêm người dùng
    Route::post('insert', 'App\Http\Controllers\api\UserController@insert');
    //update người dùng
    Route::put('update/{token}', 'App\Http\Controllers\api\UserController@update');
});

//kinh nguyệt
Route::group(['prefix' => 'kinhnguyet'], function () {
    //thêm kinh nguyệt
    Route::post('insert/{token}', 'App\Http\Controllers\api\KinhNguyetApiController@insert');
    //update kinh nguyệt
    Route::put('update/{token}', 'App\Http\Controllers\api\KinhNguyetApiController@update');
});

//kinh nguyệt
Route::group(['prefix' => 'nhatky'], function () {
    //thêm kinh nguyệt
    Route::post('insert/{token}', 'App\Http\Controllers\api\NhatKyApiController@insert');
    //update kinh nguyệt
    Route::delete('delete/{token}', 'App\Http\Controllers\api\NhatKyApiController@delete');
});
