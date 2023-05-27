<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HopTestController extends Controller
{
    // lưu dữ liệu họp test
    public function insert(Request $request) {
        $ma = $request->input('MaHopTest');

        $check = DB::table('hoptest')->insert([
            'MaHopTest' => $ma,
            'SoLuong' => 12,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // cập nhật dữ liệu người dùng vào hộp test
    public function update(Request $request, $id) {
        $maNguoiDung = $request->input('MaNguoiDung');

        //lấy người dùng trong hộp test
        $checkMaNguoiDung = DB::table('hoptest')
        ->where('MaNguoiDung', $maNguoiDung)
        ->first();

        // nếu đã tồi tại thì cộng dồn, chưa thì update
        if ($checkMaNguoiDung) {
            //nếu có thì cộng thêm số lượng
            $soluong = $checkMaNguoiDung->SoLuong + 12;
            $check = DB::table('hoptest')
            ->where('MaNguoiDung', $maNguoiDung)
            ->update([
                'SoLuong' => $soluong,
            ]);
            if ($check) {
                //insert xong thì xóa mã đi
                $del = DB::table('hoptest')->where('MaHopTest', $id)->delete();
                if ($del) {
                    return response()->json(null, 204);
                } else {
                    return response()->json(null, 400);
                }
            } else {
                return response()->json(null, 400);
            }
        } else {
            $check = DB::table('hoptest')
            ->where('MaHopTest', $id)
            ->update([
                'MaNguoiDung' => $maNguoiDung,
            ]);
            if ($check) {
                return response()->json(null, 204);
            } else {
                return response()->json(null, 400);
            }
        }
    }

    // lấy dữ liệu hộp test của người dùng
    public function get($id) {
        $check = DB::table('hoptest')->where('MaNguoiDung', $id)->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

     // xóa hộp test
    public function delete($id) {
        $check = DB::table('hoptest')->where('MaHopTest', $id)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }
}
