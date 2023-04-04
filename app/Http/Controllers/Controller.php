<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function checkLogged(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentProfileNew/HoSoSinhVien.aspx';

        $check = DB::table('student')->where('studentId', '=', $username)->get();
        if ($check->isNotEmpty()) {
            return DB::table('student')->where('studentId', '=', $username)->first();
        }
        else {
            $student = new StudentController();
            $schedule = new ScheduleController();
            $html = $login->getHTML($username, $password, $page);
            $student->parseStudentData($html);
        }
    }
}
