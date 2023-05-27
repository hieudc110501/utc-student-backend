<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NguoiDungController extends Controller
{
    // lưu dữ liệu người dùng vào bảng lấy id
    public function insert(Request $request) {

        $sdt = $request->input('MaNguoiDung');
        $ten = $request->input('TenNguoiDung');
        $namsinh = $request->input('NamSinh');
        $chieucao = $request->input('ChieuCao');
        $cannang = $request->input('CanNang');
        $nbd = $request->input('NgayBatDau');
        $tbnkn = $request->input('TBNKN');
        $snck = $request->input('SNCK');
        $snct = $request->input('SNCT');
        $ckdn = $request->input('CKDN');
        $cknn = $request->input('CKNN');

        $get = DB::table('nguoidung')->where('MaNguoiDung', $sdt)->first();
        if ($get) {
            return response()->json(false, 200);
        } else {
            $check = DB::table('nguoidung')->insert([
                'MaNguoiDung' => $sdt,
                'TenNguoiDung' => $ten,
                'NamSinh' => $namsinh,
                'ChieuCao' => $chieucao,
                'CanNang' => $cannang,
                'NgayBatDau' => $nbd,
                'TBNKN' => $tbnkn,
                'SNCK' => $snck,
                'SNCT' => $snct,
                'CKDN' => $ckdn,
                'CKNN' => $cknn,
            ]);
            if ($check) {
                return response()->json(true, 204);
            } else {
                return response()->json(null, 400);
            }
        }
    }

    // cập nhật dữ liệu người dùng vào bảng lấy id
    public function update(Request $request, $id) {
        $id = $request->input('MaNguoiDung');

        $nbd = $request->input('NgayBatDau');
        $tbnkn = $request->input('TBNKN');
        $snck = $request->input('SNCK');
        $ckdn = $request->input('CKDN');
        $cknn = $request->input('CKNN');

        $check = DB::table('nguoidung')
        ->where('MaNguoiDung', $id)
        ->update([
            'NgayBatDau' => $nbd,
            'TBNKN' => $tbnkn,
            'SNCK' => $snck,
            'CKDN' => $ckdn,
            'CKNN' => $cknn,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // cập nhật tư vấn viên vào người dùng
    public function updateTVV(Request $request, $id) {
        $maTVV = $request->input('MaTVV');

        $check = DB::table('nguoidung')
        ->where('MaNguoiDung', $id)
        ->update([
            'MaTVV' => $maTVV,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // lấy thông tin người dùng
    public function get($id) {
        $check = DB::table('nguoidung')->where('MaNguoiDung', $id)->first();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    // kiểm tra số điện thoại đã được đăng kí hay chưa
    public function check($id) {
        $check = DB::table('nguoidung')->where('MaNguoiDung', $id)->first();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

     // xóa người dùng
     public function delete($id) {
        $check = DB::table('nguoidung')->where('MaNguoiDung', $id)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }


}
