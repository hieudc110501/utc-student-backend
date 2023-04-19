<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use DateTime;

class TermController extends Controller
{
    //insert
    public function insert($username) {
        $check = DB::table('studentterm')->insert([
            'studentId' => $username,
            'termId' => 3,
        ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    //get
    public function get($username) {
        $check = DB::table('studentterm')->where('studentId', '=', $username)->value('studentTermId');
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //delete
    public function delete($username) {
        $check = DB::table('studentterm')->where('studentId', '=', $username)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }
}
