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
        $ngay_bat_dau = $request->input('ngay_bat_dau');
        $snck = $request->input('snck');
        $snct = $request->input('snct');
        $ckdn = $request->input('ckdn');
        $cknn = $request->input('cknn');

        $nguoidung = DB::table('token')->where('token', $token)->first();
        if (!empty($nguoidung)) {
            DB::table('kinhnguyet')->insert([
                'ma_nguoi_dung' => $nguoidung->ma_nguoi_dung,
                'tbnkn' => $tbnkn,
                'ngay_bat_dau' => $ngay_bat_dau,
                'snck' => $snck,
                'snct' => $snct,
                'ckdn' => $ckdn,
                'cknn' => $cknn,
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

    //update kinh nguyệt
    public function update(Request $request, $token)
    {
        $tbnkn = $request->input('tbnkn');
        $ngay_bat_dau = $request->input('ngay_bat_dau');
        $snck = $request->input('snck');
        $snct = $request->input('snct');
        $ckdn = $request->input('ckdn');
        $cknn = $request->input('cknn');

        $nguoidung = DB::table('token')->where('token', $token)->first();
        if (!empty($nguoidung)) {
            $kinhnguyet = DB::table('kinhnguyet')->where('ma_nguoi_dung', $nguoidung->ma_nguoi_dung)->first();
            if (!empty($kinhnguyet)) {
                DB::table('kinhnguyet')->update([
                    'tbnkn' => $tbnkn,
                    'ngay_bat_dau' => $ngay_bat_dau,
                    'snck' => $snck,
                    'snct' => $snct,
                    'ckdn' => $ckdn,
                    'cknn' => $cknn,
                ]);
                return response()->json([
                    'code' => 200,
                    'message' => 'update kinhnguyet success',
                ], 200);
            }

        }
        return response()->json([
            'code' => 401,
            'message' => 'update kinhnguyet unsuccess',
        ], 200);
    }
}
