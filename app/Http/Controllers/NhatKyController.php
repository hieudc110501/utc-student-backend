<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NhatKyController extends Controller
{
    //thêm nhật ký
    public function insert(Request $request, $id)
    {
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

    //lấy tất cả ngày mà người dùng đã nhập trong nhập ký
    public function getAll($id)
    {
        $check = DB::table('nhatky')->where('MaNguoiDung', $id)->pluck('ThoiGian');
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    // lấy mã nhật ký
    public function get(Request $request, $id)
    {
        $time = date('Y-m-d', strtotime($request->input('ThoiGian')));
        $check = DB::table('nhatky')
        ->where('MaNguoiDung', $id)
        ->whereDate('ThoiGian', $time)
        ->value('MaNhatKy');
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    // xóa tất cả nhật ký
    public function delete(Request $request, $id)
    {
        $time = $request->input('ThoiGian');

        $check =  DB::table('nhatky')
        ->where('MaNguoiDung', $id)
        ->where('ThoiGian', $time)
        ->delete();
        if ($check) {
            return response()->json(true, 200);
        } else {
            return response()->json(null, 400);
        }
    }
}
