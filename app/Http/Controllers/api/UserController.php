<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;



class UserController extends Controller
{
    //insert người dùng
    public function insert(Request $request)
    {
        $ma_tk = $request->input('maTaiKhoan');
        $ten = $request->input('tenNguoiDung');
        $namSinh = $request->input('namSinh');
        $chieuCao = $request->input('chieuCao');
        $canNang = $request->input('canNang');

        $maNguoiDung = DB::table('nguoidung')->insertGetId([
            'maTaiKhoan' => $ma_tk,
            'tenNguoiDung' => $ten,
            'namSinh' => $namSinh,
            'chieuCao' => $chieuCao,
            'canNang' => $canNang,
        ]);

        if ($maNguoiDung) {
            $date = Carbon::now('Asia/Ho_Chi_Minh');
            $session = DB::table('token')->insert([
                'token' => Str::random(40),
                'refreshToken' => Str::random(40),
                'tokenExpired' => date('Y-m-d H:i:s', strtotime('+30 day')),
                'refreshTokenExpired' => date('Y-m-d H:i:s', strtotime('+360 day')),
                'maNguoiDung' => $maNguoiDung,
            ]);

            if ($session) {
                return response()->json([
                    'code' => 200,
                    'data' => DB::table('token')->where('maNguoiDung', $maNguoiDung)->value('token'),
                ], 200);
            } else {
                return response()->json([
                    'code' => 401,
                    'message' => 'Fail insert token',
                ], 200);
            }
        }
        return response()->json([
            'code' => 401,
            'message' => 'Fail insert user',
        ], 200);
    }

    //update người dùng
    public function update(Request $request, $token)
    {
        $ten = $request->input('tenNguoiDung');
        $namSinh = $request->input('namSinh');
        $chieuCao = $request->input('chieuCao');
        $canNang = $request->input('canNang');

        $maNguoiDung = DB::table('token')->where('token', $token)->value('maNguoiDung');

        $update = DB::table('nguoidung')
            ->where('maNguoiDung', $maNguoiDung)
            ->update([
                'tenNguoiDung' => $ten,
                'namSinh' => $namSinh,
                'chieuCao' => $chieuCao,
                'canNang' => $canNang,
            ]);

        if ($update) {
            return response()->json([
                'code' => 200,
                'message' => 'update user success',
            ], 200);
        }
        return response()->json([
            'code' => 401,
            'message' => 'update user fail',
        ], 200);
    }
}
