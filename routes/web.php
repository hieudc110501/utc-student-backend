<?php

use App\Http\Controllers\CauHoiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HopTestController;
use App\Http\Controllers\KetQuaTestController;
use App\Http\Controllers\KinhNguyetController;
use App\Http\Controllers\NguoiDungCauTraLoi;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\NhatKyController;
use App\Http\Controllers\ThaiKiController;
use App\Http\Controllers\TVVController;
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

// //câu hỏi
// Route::group(['prefix' => 'cauhoi'], function () {
//     //lấy câu hỏi
//     Route::get('/get', [CauHoiController::class, 'get']);

//     //thêm câu hỏi
//     Route::post('/insert', [CauHoiController::class, 'insert']);

//     //cập nhật câu hỏi
//     Route::put('/update/{id}', [CauHoiController::class, 'update']);
// });

// //người dùng
// Route::group(['prefix' => 'nguoidung'], function () {
//     //thêm người dùng
//     Route::post('/insert', [NguoiDungController::class, 'insert']);

//     //cập nhật người dùng
//     Route::post('/update/{id}', [NguoiDungController::class, 'update']);

//     //cập nhật tư vấn viên vào người dùng
//     Route::post('/updateTVV/{id}', [NguoiDungController::class, 'updateTVV']);

//     //lấy người dùng
//     Route::get('/get/{id}', [NguoiDungController::class, 'get']);

//     //kiểm tra xem sdt người dùng đã có chưa
//     Route::get('/check/{id}', [NguoiDungController::class, 'check']);

//     //lấy người dùng
//     Route::delete('/delete/{id}', [NguoiDungController::class, 'delete']);
// });

// //kinh nguyệt
// Route::group(['prefix' => 'kinhnguyet'], function () {
//     //thêm kinh nguyệt của 1 người dùng
//     Route::post('/insert', [KinhNguyetController::class, 'insert']);

//     //cập nhật kinh nguyệt của 1 người dùng
//     Route::put('/update', [KinhNguyetController::class, 'update']);

//     //lấy kinh nguyệt của 1 người dùng
//     Route::get('/get/{id}', [KinhNguyetController::class, 'get']);
// });

// //câu trả lời
// Route::group(['prefix' => 'cautraloi'], function () {
//     //thêm và cập nhật câu trả lời của của 1 người dùng
//     Route::post('/insert/{id}', [NguoiDungCauTraLoi::class, 'insert']);

//     //lấy câu trả lời của người dùng theo id
//     Route::get('/get/{id}', [NguoiDungCauTraLoi::class, 'get']);

//     //xóa câu trả lời của người dùng theo id
//     Route::post('/delete/{id}', [NguoiDungCauTraLoi::class, 'delete']);

//     //update câu trả lời của người dùng theo id
//     Route::post('/update/{id}', [NguoiDungCauTraLoi::class, 'update']);
// });


// //hộp test
// Route::group(['prefix' => 'hoptest'], function () {
//     //thêm người dùng
//     Route::post('/insert', [HopTestController::class, 'insert']);

//     //cập nhật người dùng
//     Route::put('/update/{id}', [HopTestController::class, 'update']);

//     //lấy người dùng
//     Route::get('/get/{id}', [HopTestController::class, 'get']);

//     //lấy người dùng
//     Route::delete('/delete/{id}', [HopTestController::class, 'delete']);
// });

// //kết quả test
// Route::group(['prefix' => 'ketquatest'], function () {
//     //thêm người dùng
//     Route::post('/insert/{id}', [KetQuaTestController::class, 'insert']);

//     //lấy số lần test theo que
//     Route::get('/getCount/{id}', [KetQuaTestController::class, 'getCount']);

//     //lấy số tổng số lần test
//     Route::get('/getAllCount/{id}', [KetQuaTestController::class, 'getAllCount']);

//     //xóa tất cả lần test của một mã hộp
//     Route::delete('/delete/{id}', [KetQuaTestController::class, 'delete']);
// });


// //tư vấn viên
// Route::group(['prefix' => 'tvv'], function () {
//     //thêm tư vấn viên
//     Route::post('/insert', [TVVController::class, 'insert']);

//     //update tư vấn viên
//     Route::put('/update/{id}', [TVVController::class, 'update']);

//     //lấy tư vấn viên theo id
//     Route::get('/get/{id}', [TVVController::class, 'get']);

//     //lấy tất cả tư vấn viên
//     Route::get('/getAll', [TVVController::class, 'getAll']);

//     //xóa tư vấn viên theo id
//     Route::delete('/delete/{id}', [TVVController::class, 'delete']);
// });


// //tư vấn viên
// Route::group(['prefix' => 'nhatky'], function () {
//     //lấy tất cả ngày mà người dùng đã nhập trong nhập ký
//     Route::post('/insert/{id}', [NhatKyController::class, 'insert']);

//     //lấy mã nhật ký
//     Route::get('/get/{id}', [NhatKyController::class, 'get']);

//     //lấy tất cả ngày mà người dùng đã nhập trong nhập ký
//     Route::get('/getAll/{id}', [NhatKyController::class, 'getAll']);

//     //xóa tất cả nhật ký theo id người dùng
//     Route::post('/delete/{id}', [NhatKyController::class, 'delete']);
// });


// //thai kì
// Route::group(['prefix' => 'thaiki'], function () {
//     //thêm tư thai kì
//     Route::post('/insert/{id}', [ThaiKiController::class, 'insert']);

//     //update tư thai kì
//     Route::put('/update/{id}', [ThaiKiController::class, 'update']);

//     //lấy tư thai kì theo id người dùng
//     Route::get('/get/{id}', [ThaiKiController::class, 'get']);

//     //xóa tư thai kì theo id người dùng
//     Route::delete('/delete/{id}', [ThaiKiController::class, 'delete']);
// });

// //user
// Route::group(['prefix' => 'user'], function () {
//     //lấy tư thai kì theo id người dùng
//     Route::get('/get', [Controller::class, 'get']);
//     Route::post('/post', [Controller::class, 'post']);
//     Route::delete('/delete', [Controller::class, 'delete']);
// });
