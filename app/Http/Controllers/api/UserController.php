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
        $ma_tk = $request->input('ma_tai_khoan');
        $ten = $request->input('ten_nguoi_dung');
        $nam_sinh = $request->input('nam_sinh');
        $chieu_cao = $request->input('chieu_cao');
        $can_nang = $request->input('can_nang');

        $ma_nguoi_dung = DB::table('nguoidung')->insertGetId([
            'ma_tai_khoan' => $ma_tk,
            'ten_nguoi_dung' => $ten,
            'nam_sinh' => $nam_sinh,
            'chieu_cao' => $chieu_cao,
            'can_nang' => $can_nang,
        ]);

        if ($ma_nguoi_dung) {
            $date = Carbon::now('Asia/Ho_Chi_Minh');
            $session = DB::table('token')->insert([
                'token' => Str::random(40),
                'refresh_token' => Str::random(40),
                'token_expried' => date('Y-m-d H:i:s', strtotime('+30 day')),
                'refresh_token_expried' => date('Y-m-d H:i:s', strtotime('+360 day')),
                'ma_nguoi_dung' => $ma_nguoi_dung,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            if ($session) {
                return response()->json([
                    'code' => 200,
                    'data' => DB::table('token')->where('ma_nguoi_dung', $ma_nguoi_dung)->value('token'),
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
        $ten = $request->input('ten_nguoi_dung');
        $nam_sinh = $request->input('nam_sinh');
        $chieu_cao = $request->input('chieu_cao');
        $can_nang = $request->input('can_nang');

        $ma_nguoi_dung = DB::table('token')->where('token', $token)->value('ma_nguoi_dung');

        $update = DB::table('nguoidung')
            ->where('ma_nguoi_dung', $ma_nguoi_dung)
            ->update([
                'ten_nguoi_dung' => $ten,
                'nam_sinh' => $nam_sinh,
                'chieu_cao' => $chieu_cao,
                'can_nang' => $can_nang,
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
