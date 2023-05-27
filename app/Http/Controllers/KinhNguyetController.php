<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KinhNguyetController extends Controller
{
    // lưu chu kì kinh nguyệt của một người dùng
    public function insert(Request $request) {
        $id = $request->input('MaNguoiDung');
        $tbnkn = $request->input('TBNKN');
        $nbd = $request->input('NgayBatDau');
        $snck = $request->input('SNCK');
        $snct = $request->input('SNCT');
        $ckdn = $request->input('CKDN');
        $cknn = $request->input('CKNN');

        $check = DB::table('kinhnguyet')->insert([
            'MaNguoiDung' => $id,
            'TBNKN' => $tbnkn,
            'NgayBatDau' => $nbd,
            'SNCK' => $snck,
            'SNCT' => $snct,
            'CKDN' => $ckdn,
            'CKNN' => $cknn,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // cập nhật chu kì kinh nguyệt của một người dùng
    public function update(Request $request) {
        $id = $request->input('MaNguoiDung');
        $tbnkn = $request->input('TBNKN');
        $nbd = $request->input('NgayBatDau');
        $snck = $request->input('SNCK');
        $snct = $request->input('SNCT');
        $ckdn = $request->input('CKDN');
        $cknn = $request->input('CKNN');

        $check = DB::table('kinhnguyet')
            ->where('MaNguoiDung', $id)
            ->update([
            'TBNKN' => $tbnkn,
            'NgayBatDau' => $nbd,
            'SNCK' => $snck,
            'SNCT' => $snct,
            'CKDN' => $ckdn,
            'CKNN' => $cknn,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // lấy chu kì kinh nguyệt của một người dùng
    public function get($id) {
        $check = DB::table('kinhnguyet')->where('MaNguoiDung', $id)->first();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }
}
