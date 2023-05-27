<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // public function get() {
    //     $check = DB::table('user')->get();
    //     if ($check) {
    //         return response()->json($check, 200);
    //     } else {
    //         return response()->json(null, 400);
    //     }
    // }

    // public function post(Request $request) {
    //     $firstName = $request->input('firstName');
    //     $lastName = $request->input('lastName');
    //     $check = DB::table('user')->insert([
    //         'firstName' => $firstName,
    //         'lastName' => $lastName,
    //     ]);
    //     if ($check) {
    //         return response()->json(null, 200);
    //     } else {
    //         return response()->json(null, 400);
    //     }
    // }

    // public function delete(Request $request) {
    //     $firstName = $request->input('firstName');
    //     $lastName = $request->input('lastName');
    //     $check = DB::table('user')
    //     ->where('firstName', $firstName)
    //     ->where('lastName', $lastName)
    //     ->delete();
    //     if ($check) {
    //         return response()->json(null, 200);
    //     } else {
    //         return response()->json(null, 400);
    //     }
    // }
}
