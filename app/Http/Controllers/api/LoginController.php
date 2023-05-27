<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;



class LoginController extends Controller
{
    public function login(Request $request)
    {
        $tk = $request->input('ten_tai_khoan');
        $mk = $request->input('mat_khau');

        // lấy ra tài khoản mật khẩu giả mã và so sánh
        $taikhoan = DB::table('taikhoan')->where('ten_tai_khoan', $tk)->first();
        if ($taikhoan && Hash::check($mk, $taikhoan->mat_khau)) {

            //kiểm tra xem người dùng đã có chưa
            $nguoidung = DB::table('nguoidung')->where('ma_tai_khoan', $taikhoan->ma_tai_khoan)->first();
            if (empty($nguoidung)) {
                return response()->json([
                    'code' => 200,
                    'ma_tai_khoan' => $taikhoan->ma_tai_khoan,
                ], 200);
            } else {
                $checkTokenExist = DB::table('token')->where('ma_nguoi_dung', $nguoidung->ma_nguoi_dung)->first();

                //check xem đã có token hay chưa
                if (empty($checkTokenExist)) {
                    $date = Carbon::now('Asia/Ho_Chi_Minh');
                    $session = DB::table('token')->insert([
                        'token' => Str::random(40),
                        'refresh_token' => Str::random(40),
                        'token_expried' => date('Y-m-d H:i:s', strtotime('+30 day')),
                        'refresh_token_expried' => date('Y-m-d H:i:s', strtotime('+360 day')),
                        'ma_nguoi_dung' => $nguoidung->ma_nguoi_dung,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                } else {
                    $session = $checkTokenExist;
                }
                return response()->json([
                    'code' => 200,
                    'data' => $session,
                ], 200);
            }
        } else {
            return response()->json([
                'code' => 401,
                'message' => 'user name or password not match',
            ], 200);
        }
    }
}
