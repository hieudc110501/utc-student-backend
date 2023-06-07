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
        $thoiGian = $request->input('thoiGian');

        $nguoidung = DB::table('token')->where('token', $token)->first();
        if (!empty($nguoidung)) {
            $nhatky = DB::table('nhatky')
                ->where('maNguoiDung', $nguoidung->maNguoiDung)
                ->where('thoiGian', $thoiGian)
                ->first();

            if (empty($nhatky)) {
                DB::table('nhatky')->insert([
                    'maNguoiDung' => $nguoidung->maNguoiDung,
                    'thoiGian' => $thoiGian,
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
        $thoiGian = $request->input('thoiGian');

        $nguoidung = DB::table('token')->where('token', $token)->first();
        if (!empty($nguoidung)) {
            $nhatky = DB::table('nhatky')
                ->where('maNguoiDung', $nguoidung->maNguoiDung)
                ->where('thoiGian', $thoiGian)
                ->first();

            if (!empty($nhatky)) {
                DB::table('nhatky')->where('maNhatKy', $nhatky->maNhatKy)->delete();
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
