<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KetQuaTestController extends Controller
{
    // lưu kết quả test
    public function insert(Request $request, $maHopTest) {
        $kq = $request->input('KetQua');
        $loaique = $request->input('LoaiQue');
        $date = Carbon::now('Asia/Ho_Chi_Minh');

        $check = DB::table('ketquatest')->insert([
            'MaHopTest' => $maHopTest,
            'LoaiQue' => $loaique,
            'LanThu' => $this->getCount($request, $maHopTest)+1,
            'ThoiGian' => $date,
            'KetQua' => $kq,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // lấy tổng số lần test theo que
    public function getCount(Request $request, $maHopTest) {
        $loaique = $request->input('LoaiQue');
        $count = DB::table('ketquatest')
        ->where('MaHopTest', $maHopTest)
        ->where('LoaiQue', $loaique)
        ->getCountForPagination();
        return $count;
    }

    // lấy tổng số lần test
    public function getAllCount($maHopTest) {
        $count = DB::table('ketquatest')
        ->where('MaHopTest', $maHopTest)
        ->getCountForPagination();
        return $count;
    }

    // xóa tất cả lần test của một hộp
    public function delete($id) {
        $check = DB::table('ketquatest')->where('MaHopTest', $id)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

}
