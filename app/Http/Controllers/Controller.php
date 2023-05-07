<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function fetchData(Request $request)
    {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $pageStudent = 'StudentProfileNew/HoSoSinhVien.aspx';
        $pageSchedule = 'StudyRegister/StudyRegister.aspx';
        $pageMark = 'StudentMark.aspx';

        $check = DB::table('student')->where('studentId', '=', $username)->get();
        if ($check->isNotEmpty()) {
            return DB::table('student')->where('studentId', '=', $username)->first();
        } else {
            $student = new StudentController();
            $schedule = new ScheduleController();
            $html = $login->getHTML($username, $password, $pageStudent);
            $check = $student->parseStudentData($html);

            //schedule
            $html1 = $login->getHTML($username, $password, $pageSchedule);
            $check1 = $schedule->parseSchedule($html1, $username);

            if ($check && $check1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteAll($username)
    {
        $mark = new MarkController();
        $point = new PointController();
        $schedule = new ScheduleController();
        $tuition = new TuitionController();
        $student = new StudentController();
        $term = new TermController();

        $d1 = $mark->deleteAll($username);
        $d2 = $point->delete($username);
        $d3 = $schedule->delete($username);
        $d4 = $schedule->deleteExam($username);
        $d7 = $term->delete($username);
        $d5 = $tuition->delete($username);
        $d6 = $student->delete($username);

        if ($d1 && $d2 && $d3 && $d4 && $d5 && $d6 && $d7) {
            return response()->json(true, 200);
        }
        return  response()->json(null, 400);
    }
}
