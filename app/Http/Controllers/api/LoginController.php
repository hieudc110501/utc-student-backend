<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    //login and create token
    public function login(Request $request)
    {
        $tk = $request->input('tenTaiKhoan');
        $mk = $request->input('matKhau');

        $credentials = [
            'tenTaiKhoan' => $tk,
            'password' => $mk,
        ];

        if (Auth::attempt($credentials)) {
            //kiểm tra xem người dùng đã có chưa
            $taikhoan = DB::table('taikhoan')->where('tenTaiKhoan', $tk)->first();
            $nguoidung = DB::table('nguoidung')->where('maTaiKhoan', $taikhoan->maTaiKhoan)->first();
            if (empty($nguoidung)) {
                return response()->json([
                    'code' => 200,
                    'maTaiKhoan' => $taikhoan->maTaiKhoan,
                ], 200);
            } else {
                $checkTokenExist = DB::table('token')->where('maNguoiDung', $nguoidung->maNguoiDung)->first();

                //check xem đã có token hay chưa
                if (empty($checkTokenExist)) {
                    $date = Carbon::now('Asia/Ho_Chi_Minh');
                    $session = DB::table('token')->insert([
                        'token' => Str::random(40),
                        'refreshToken' => Str::random(40),
                        'tokenExpired' => date('Y-m-d H:i:s', strtotime('+30 day')),
                        'refreshTokenExpired' => date('Y-m-d H:i:s', strtotime('+360 day')),
                        'maNguoiDung' => $nguoidung->maNguoiDung,
                        'createdAt' => $date,
                        'updatedAt' => $date,
                    ]);
                } else {
                    $session = $checkTokenExist;
                }
                return response()->json([
                    'code' => 200,
                    'token' => $session->token,
                ], 200);
            }
        } else {
            return response()->json([
                'code' => 401,
                'message' => 'user name or password not match',
            ], 200);
        }
    }

    // logout delete token
    public function logout(Request $request)
    {
        $token = $request->input('token');
        $checkTokenIsValid = DB::table('token')->where('token', $token)->first();
        if (!empty($checkTokenIsValid)) {
            DB::table('token')->where('token', $token)->delete();
        }
        return response()->json([
            'code' => 200,
            'message' => 'logout success',
        ], 200);
    }

    // refresh token
    public function refresh_token(Request $request)
    {
        $token = $request->input('token');
        $checkTokenIsValid = DB::table('token')->where('token', $token)->first();
        if (!empty($checkTokenIsValid)) {
            $currentDateTime = Carbon::now();
            $tokenExpiredDateTime = Carbon::parse($checkTokenIsValid->token_expired);

            if ($tokenExpiredDateTime < $currentDateTime) {
                var_dump('referh');
                DB::table('token')->update([
                    'token' => Str::random(40),
                    'refreshToken' => Str::random(40),
                    'tokenExpired' => date('Y-m-d H:i:s', strtotime('+30 day')),
                    'refreshTokenExpired' => date('Y-m-d H:i:s', strtotime('+360 day'))
                ]);
            }
        }
        return response()->json([
            'code' => 200,
            'message' => 'refresh token success',
        ], 200);
    }
}
