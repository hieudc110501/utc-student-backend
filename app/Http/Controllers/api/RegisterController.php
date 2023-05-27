<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class RegisterController extends Controller
{
    public function register(Request $request) {
        $maTK = (string) Str::uuid();
        $maPQ = 4;
        $tk = $request->input('ten_tai_khoan');
        $mk = $request->input('mat_khau');
        $date = Carbon::now('Asia/Ho_Chi_Minh');

        $insert = DB::table('TaiKhoan')->insert([
            'ma_tai_khoan' => $maTK,
            'ma_phan_quyen' => $maPQ,
            'ten_tai_khoan' => $tk,
            'mat_khau' => bcrypt($mk),
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        return response()->json($insert, 200);
    }
}
