<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TaiKhoanController extends Controller
{
    //thêm nhật ký
    public function insert(Request $request, $id)
    {
        $time = $request->input('ThoiGian');
        $time = $request->input('ThoiGian');
        $time = $request->input('ThoiGian');
        $check =  DB::table('nhatky')->insertGetId([
            'MaNguoiDung' => $id,
            'ThoiGian' => $time,
        ]);
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }
}
