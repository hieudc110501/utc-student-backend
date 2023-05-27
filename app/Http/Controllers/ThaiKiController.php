<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ThaiKiController extends Controller
{

    //thêm thai kì của người dùng
    public function insert(Request $request, $id) {
        $ngayQuanHe = $request->input('NgayQuanHe');
        $ngayTestThuThai = $request->input('NgayTestThuThai');
        $kqVangDa = $request->input('KetQuaVangDa');

        $check = DB::table('thaiki')->insert([
            'MaNguoiDung' => $id,
            'NgayQuanHe' => $ngayQuanHe,
            'NgayTestThuThai' => $ngayTestThuThai,
            'KetQuaVangDa' => $kqVangDa,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    //lấy thông tin thai kì của người dùng
    public function get($id) {
        $check = DB::table('thaiki')->where('MaNguoiDung', $id)->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    // xóa người dùng thông tin thai kì của người dùng
    public function delete($id) {
        $check = DB::table('thaiki')->where('MaNguoiDung', $id)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // xóa người dùng thông tin thai kì của người dùng
    public function update(Request $request, $id) {
        $tk = DB::table('thaiki')->where('MaNguoiDung', $id)->first();
        $ngayQuanHe = $request->input('NgayQuanHe');
        $ngayTestThuThai = $request->input('NgayTestThuThai');
        $kqVangDa = $request->input('KetQuaVangDa');

        $check = DB::table('thaiki')
        ->where('MaNguoiDung', $id)
        ->update([
            'NgayQuanHe' => $ngayQuanHe ? $ngayQuanHe : $tk->NgayQuanHe,
            'NgayTestThuThai' => $ngayTestThuThai ? $ngayTestThuThai : $tk->NgayTestThuThai,
            'KetQuaVangDa' => $kqVangDa ? $kqVangDa : $tk->KetQuaVangDa,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }


}
