<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TVVController extends Controller
{
    // lưu dữ liệu người dùng vào bảng lấy id
    public function insert(Request $request) {
        $ten = $request->input('TenTVV');
        $link = $request->input('Link');
        $sdt = $request->input('SoDienThoai');
        $anh = $request->input('Anh');

        $check = DB::table('tvv')->insert([
            'TenTVV' => $ten,
            'Link' => $link,
            'SoDienThoai' => $sdt,
            'Anh' => $anh,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // cập nhật dữ liệu tư vấn viên
    public function update(Request $request, $id) {
        $tvv = DB::table('tvv')->where('MaTVV', $id)->first();

        $ten = $request->input('TenTVV');
        $link = $request->input('Link');
        $sdt = $request->input('SoDienThoai');
        $anh = $request->input('Anh');

        $check = DB::table('tvv')
        ->where('MaTVV', $id)
        ->update([
            'TenTVV' => $ten ? $ten : $tvv->TenTVV,
            'Link' => $link ? $link : $tvv->Link,
            'SoDienThoai' => $sdt ? $sdt : $tvv->SoDienThoai,
            'Anh' => $anh ? $anh : $tvv->Anh,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // lấy tư vấn viên theo id
    public function get($id) {
        $check = DB::table('tvv')->where('MaTVV', $id)->first();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    // lấy tất cả tư vân viên
    public function getAll() {
        $check = DB::table('tvv')->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

     // xóa tư vấn viên theo id
     public function delete($id) {
        $check = DB::table('tvv')->where('MaTVV', $id)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }


}
