<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NguoiDungCauTraLoi extends Controller
{
    //insert
    public function insert(Request $request, $id)
    {
        $maCauHoi = $request->input('MaCauHoi');
        $cauTraLoi = $request->input('CauTraLoi');
        $check = DB::table('nguoidungcautraloi')->insert([
            'MaNhatKy' => $id,
            'MaCauHoi' => $maCauHoi,
            'CauTraLoi' => $cauTraLoi,
        ]);

        if ($check) {
            return response()->json(true, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //get
    public function get($id)
    {
        $check = DB::table('nguoidungcautraloi')
            ->where('MaNhatKy', $id)
            ->get();

        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //delete
    public function delete($id)
    {
        $check = DB::table('nguoidungcautraloi')
            ->where('MaNhatKy', $id)
            ->delete();

        if ($check) {
            return response()->json(true, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //update
    public function update(Request $request, $id)
    {
        $maCauHoi = $request->input('MaCauHoi');
        $cauTraLoi = $request->input('CauTraLoi');
        $check = DB::table('nguoidungcautraloi')
            ->where('MaNhatKy', $id)
            ->where('MaCauHoi', $maCauHoi)
            ->update([
                'CauTraLoi' => $cauTraLoi,
            ]);

        if ($check) {
            return response()->json(true, 200);
        } else {
            return response()->json(null, 400);
        }
    }
}
