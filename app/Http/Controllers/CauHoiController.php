<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CauHoiController extends Controller
{
    public function get() {
        return DB::table('cauhoi')->get();
    }

    public function insert(Request $request) {
        $nd = $request->input('NoiDung');
        $check = DB::table('cauhoi')->insert([
            'NoiDung' => $nd,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    public function update(Request $request, $id) {
        $nd = $request->input('NoiDung');
        $check = DB::table('cauhoi')
        ->where('MaCauHoi', $id)
        ->update([
            'NoiDung' => $nd,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

}
