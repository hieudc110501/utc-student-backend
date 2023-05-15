<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function insertAll(Request $request)
    {
        $mark = new MarkController();
        $point = new PointController();
        $schedule = new ScheduleController();
        $tuition = new TuitionController();
        $student = new StudentController();

        $d6 = $student->insert($request, 0);
        $d3 = $schedule->insert($request);
        $d4 = $schedule->insertExam($request);
        $d1 = $mark->insertMarkTerm($request);
        $d7 = $mark->insertGPA($request);
        $d2 = $point->insert($request);
        $d5 = $tuition->insert($request);


        if ($d1 && $d2 && $d3 && $d4 && $d5 && $d6 && $d7) {
            $check = $student->insert($request, 1);
            if ($check) {
                return response()->json(true, 200);
            }
        }
        return  response()->json(null, 400);
    }

    public function deleteAll($username)
    {
        $mark = new MarkController();
        $point = new PointController();
        $schedule = new ScheduleController();
        $tuition = new TuitionController();
        //$student = new StudentController();
        $term = new TermController();

        $d1 = $mark->deleteAll($username);
        $d2 = $point->delete($username);
        $d3 = $schedule->delete($username);
        $d4 = $schedule->deleteExam($username);
        $d7 = $term->delete($username);
        $d5 = $tuition->delete($username);
        //$d6 = $student->delete($username);

        if ($d1 && $d2 && $d3 && $d4 && $d5 && $d7) {
            return response()->json(true, 200);
        }
        return  response()->json(null, 400);
    }
}
