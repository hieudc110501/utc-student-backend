<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\taikhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $check = DB::table('taikhoan')->where('tenTaiKhoan', $request->tenTaiKhoan)->first();
        if ($check) {
            return response()->json(false, 200);
        }

        $insert = taikhoan::create([
            'maTaiKhoan' => (string) Str::uuid(),
            'maPhanQuyen' => 4,
            'tenTaiKhoan' => $request->tenTaiKhoan,
            'matKhau' => bcrypt($request->matKhau),
        ]);

        if (empty($insert)) {
            return response()->json(false, 401);
        }
        return response()->json(true, 200);
    }
}
