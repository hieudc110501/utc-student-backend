<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NhatKyApiController extends Controller
{
    //insert nhật ký
    public function insert(Request $request, $token)
    {
        $thoi_gian = $request->input('thoi_gian');

        $nguoidung = DB::table('token')->where('token', $token)->first();
        if (!empty($nguoidung)) {
            $nhatky = DB::table('nhatky')
                ->where('ma_nguoi_dung', $nguoidung->ma_nguoi_dung)
                ->where('thoi_gian', $thoi_gian)
                ->first();

            if (empty($nhatky)) {
                DB::table('nhatky')->insert([
                    'ma_nguoi_dung' => $nguoidung->ma_nguoi_dung,
                    'thoi_gian' => $thoi_gian,
                ]);
                return response()->json([
                    'code' => 200,
                    'message' => 'insert nhatky success',
                ], 200);
            }
        }
        return response()->json([
            'code' => 401,
            'message' => 'insert nhatky unsuccess',
        ], 200);
    }

    //delete nhật ký
    public function delete(Request $request, $token)
    {
        $thoi_gian = $request->input('thoi_gian');

        $nguoidung = DB::table('token')->where('token', $token)->first();
        if (!empty($nguoidung)) {
            $nhatky = DB::table('nhatky')
                ->where('ma_nguoi_dung', $nguoidung->ma_nguoi_dung)
                ->where('thoi_gian', $thoi_gian)
                ->first();

            if (!empty($nhatky)) {
                DB::table('nhatky')->where('ma_nhat_ky', $nhatky->ma_nhat_ky)->delete();
                return response()->json([
                    'code' => 200,
                    'message' => 'delete nhatky success',
                ], 200);
            }
        }
        return response()->json([
            'code' => 401,
            'message' => 'delete nhatky unsuccess',
        ], 200);
    }
}
