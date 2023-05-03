<?php

namespace App\Http\Controllers;
use App\Http\Controllers\LoginController;
use DateTime;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{

    //tách dữ liệu lấy lịch học
    public function parseSchedule($html, $username) {
        $crawler = new Crawler($html);
        $rows = $crawler->filter('#gridRegistered tr')->each(function ($row, $i) {
            if ($i === 0) {
                return null;
            }
            // extract data from the row
            $cols = $row->filter('td')->each(function (Crawler $col, $j) {
                return trim($col->text());
            });
            // skip empty rows
            if (empty($cols[0])) {
                return null;
            }
            return $cols;
        });

        $id = $username;

        $rows = array_filter($rows);
        unset($rows[sizeof($rows)]);

        foreach ($rows as $value) {
            $subjectName = trim($value['1']);
            $subjectId = trim($value['2']);
            $string1 = trim($value['3']);
            $string = trim($value['4']);

            // lấy địa điểm học
            $array = array();
            if (str_contains($string, "(1)")) {
                $list = explode("(1)", $string);
                $string = $list[1];
            }
            if (str_contains($string, "(1,2)")) {
                $list = explode("(1,2)", $string);
                $string = $list[1];
            }
            if (str_contains($string, "(2)")) {
                $list = explode("(2)", $string);
                array_push($array, $list[0]);
                $string = $list[1];
            }
            if (str_contains($string, "(2,3)")) {
                $list = explode("(2,3)", $string);
                array_push($array, $list[0]);
                $string = $list[1];
            }
            if (str_contains($string, "(3)")) {
                $list = explode("(3)", $string);
                array_push($array, $list[0]);
                $string = $list[1];
            }
            if (sizeof($array) == 0) {
                array_push($array, $string);
            } else {
                array_push($array, $list[1]);
            }

            // lấy thứ và tiết
            $listDay = array_filter(explode("Từ", trim($string1)));
            //var_dump($listDay);
            $index = 0;
            foreach ($listDay as $listd) {
                $time = explode(":", $listd);
                //tách lấy ngày bắt đầu và ngày kết thúc
                $day = $time[0];
                $startDay = date("Y-m-d", strtotime(str_replace('/', '-',trim(explode("đến", $day)[0]))));
                $endDay = date("Y-m-d", strtotime(str_replace('/', '-',trim(explode("đến", $day)[1]))));

                $listThu = explode("Thứ", $time[1]);
                if (sizeof($listThu) == 1) {
                    $check = DB::table('subjectdetail')->insert([
                        'studentId' => $id,
                        'subjectId' => $subjectId,
                        'subjectName' => $subjectName,
                        'startDay' => $startDay,
                        'endDay' => $endDay,
                    ]);
                    if (!$check) {
                        return response()->json(null, 400);
                    }
                    //var_dump($subjectId . ' ' . $startDay . ' ' . $endDay . ' ' . 'null' . ' ' . 'null' . ' ' . 'null');
                } else {
                    unset($listThu[0]);
                    foreach ($listThu as $listt) {
                        $listTiet = explode("tiết", $listt);
                        $ca = '1';
                        if (str_contains($listTiet[1], '1,2,3')) {
                            $ca = '1';
                        } else if (str_contains($listTiet[1], '4,5,6')) {
                            $ca = '2';
                        } else if (str_contains($listTiet[1], '7,8,9')) {
                            $ca = '3';
                        } else if (str_contains($listTiet[1], '10,11,12')) {
                            $ca = '4';
                        }
                        $check = DB::table('subjectdetail')->insert([
                            'studentId' => $id,
                            'subjectId' => $subjectId,
                            'subjectName' => $subjectName,
                            'startDay' => $startDay,
                            'endDay' => $endDay,
                            'weekDay' => (int) trim($listTiet[0]),
                            'lesson' => (int) trim($ca),
                            'location' => $array[$index],
                        ]);
                        if (!$check) {
                            return response()->json(null, 400);
                        }
                        //var_dump($subjectId . ' ' . $startDay . ' ' . $endDay . ' ' . trim($listTiet[0]) . ' ' . $ca . ' ' . $array[$index]);
                    }
                }
                sizeof($array)-1 > $index ? $index++ : $index;
            }
        }
        return response()->json(null, 204);
    }

    //insert schedule
    public function insert(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');

        $page = 'Reports/Form/StudentTimeTable.aspx';

        //$termId = DB::table('studentterm')->where('studentId', $username)->value('termId');
        $termValue = DB::table('term')->where('termId', '2022_2023_2')->value('termValue');
        $html = $login->getScheduleHTML($username, $password, $page, $termValue);
        //return $html;
        return $this->parseSchedule($html, $username);
    }

    //get schedule
    public function get($username) {
        $studentTermId = DB::table('studentterm')->where('studentId', $username)->value('studentTermId');
        $check = DB::table('subjectdetail')->where('studentTermId', $studentTermId)->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //delete schedule
    public function delete($username) {
        $studentTermId = DB::table('studentterm')->where('studentId', $username)->value('studentTermId');
        $check = DB::table('subjectdetail')->where('studentTermId', $studentTermId)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    // tách lấy dữ liệu lịch thi
    public function parseExam($html, $username) {
        $crawler = new Crawler($html);
        // Find the select element with the name "hieu"
        //$select = $crawler->filter('select[name="drpSemester"]')->first();

        $rows = $crawler->filter('#tblCourseList tr')->each(function ($row, $i) {
            if ($i === 0) {
                return null;
            }
            // extract data from the row
            $cols = $row->filter('td')->each(function (Crawler $col, $j) {
                return trim($col->text());
            });
            // skip empty rows
            if (empty($cols[0])) {
                return null;
            }
            return $cols;
        });

        $rows = array_filter($rows);
        foreach($rows as $row) {
            $check = DB::table('exam')->insert([
                'studentId' => $username,
                'moduleId' => $row[1],
                'moduleName' => $row[2],
                'credit' => $row[3],
                'date' => date("Y-m-d", strtotime(str_replace('/', '-',trim($row[4])))),
                'lesson' => $row[5],
                'type' => $row[6],
                'identify' => $row[7],
                'room' => $row[8],
            ]);

            if (!$check) {
                return response()->json(null, 400);
            }
        }
        return response()->json(null, 204);
    }

    //insert lịch thi
    public function insertExam(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentViewExamList.aspx';

        $termValue = DB::table('term')->where('termId', '=', '2022_2023_2')->value('termValue');
        $html = $login->getExamHTML($username, $password, $page, $termValue);
        return $this->parseExam($html, $username);
    }

    //delete lịch thi
    public function deleteExam($username) {
        $check = DB::table('exam')->where('studentId', $username)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

     //delete lịch thi
     public function getExam($username) {
        $check = DB::table('exam')->where('studentId', $username)->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }
}
