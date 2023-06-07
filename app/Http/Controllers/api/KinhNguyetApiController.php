<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class KinhNguyetApiController extends Controller
{
    //insert kinh nguyệt
    public function insert(Request $request, $token)
    {
        $tbnkn = $request->input('tbnkn');
        $snck = $request->input('snck');
        $snct = $request->input('snct');
        $ckdn = $request->input('ckdn');
        $cknn = $request->input('cknn');
        $ngayBatDau = $request->input('ngayBatDau');
        $ngayKetThuc = $request->input('ngayKetThuc');
        $ngayBatDauKinh = $request->input('ngayBatDauKinh');
        $ngayKetThucKinh = $request->input('ngayKetThucKinh');
        $ngayBatDauTrung = $request->input('ngayBatDauTrung');
        $ngayKetThucTrung = $request->input('ngayKetThucTrung');
        $trangThai = $request->input('trangThai');

        $nguoidung = DB::table('token')->where('token', $token)->first();
        if (!empty($nguoidung)) {
            DB::table('kinhnguyet')->insert([
                'maNguoiDung' => $nguoidung->maNguoiDung,
                'tbnkn' => $tbnkn,
                'snck' => $snck,
                'snct' => $snct,
                'ckdn' => $ckdn,
                'cknn' => $cknn,
                'ngayBatDau' => $ngayBatDau,
                'ngayKetThuc' => $ngayKetThuc,
                'ngayBatDauKinh' => $ngayBatDauKinh,
                'ngayKetThucKinh' => $ngayKetThucKinh,
                'ngayBatDauTrung' => $ngayBatDauTrung,
                'ngayKetThucTrung' => $ngayKetThucTrung,
                'trangThai' => $trangThai,
            ]);
            return response()->json([
                'code' => 200,
                'message' => 'insert kinhnguyet success',
            ], 200);
        }
        return response()->json([
            'code' => 401,
            'message' => 'insert kinhnguyet unsuccess',
        ], 200);
    }

    //delete kinh nguyệt
    public function delete($token)
    {
        $nguoidung = DB::table('token')->where('token', $token)->first();
        if (!empty($nguoidung)) {
            $delete = DB::table('kinhnguyet')->where('maNguoiDung', $nguoidung->maNguoiDung)->delete();
            if ($delete) {
                return response()->json([
                    'code' => 200,
                    'message' => 'delete kinhnguyet success',
                ], 200);
            }
        }
    }
}
