<?php

namespace App\Http\Controllers;
use App\Http\Controllers\LoginController;
use DateTime;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{

    // tách dữ liệu lịch học
    public function parseSchedule($html, $username) {
        $crawler = new Crawler($html);
        $rows = $crawler->filter('#tblOtherCourseClass tr')->each(function ($row, $i) {
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

        // lưu vào bảng StudentTerm
        $studentTermId = DB::table('studentterm')->insertGetId([
            'studentId' => $username,
            'termId' => $rows['1']['4'],
        ]);

        // lưu các môn học ứng với từng sinh viên theo kì vào bảng
        foreach ($rows as $value) {
            if (DB::table('subject')->where('subjectName', '=', $value['1'])->first() == null) {
                $subjectId = DB::table('subject')->insertGetId([
                    'subjectName' => $value['1'],
                ]);
                $studentsubjecttermid = DB::table('studentsubjectterm')->insertGetId([
                    'studentTermId' => $studentTermId,
                    'subjectId' => $subjectId,
                ]);
                $listDate = explode("Từ", $value['2']);
                foreach($listDate as $date) {

                    if ($date != '') {
                        $time = explode(":", $date);
                        //tách lấy ngày bắt đầu và ngày kết thúc
                        $day = $time[0];
                        $startDay = date("Y-m-d", strtotime(str_replace('/', '-',explode("đến", $day)[0])));
                        $endDay = date("Y-m-d", strtotime(str_replace('/', '-',explode("đến", $day)[1])));


                        //tách lấy tiết học
                        $lesson = explode("tiết", $time[1]);
                        //nếu có tiết học thì lấy tiết học và ca
                        if (sizeof($lesson) != 1) {
                            $weekDay = trim($lesson[0])[strlen(trim($lesson[0]))-1];
                            $ca = '1';
                            if (str_contains($lesson[1], '1,2,3')) {
                                $ca = '1';
                            } else if (str_contains($lesson[1], '4,5,6')) {
                                $ca = '2';
                            } else if (str_contains($lesson[1], '7,8,9')) {
                                $ca = '3';
                            } else if (str_contains($lesson[1], '10,11,12')) {
                                $ca = '4';
                            }
                            DB::table('subjectdetail')->insert([
                                'studentSubjectTermId' => $studentsubjecttermid,
                                'startDay' => $startDay,
                                'endDay' => $endDay,
                                'lesson' => $ca,
                                'weekday' => $weekDay,
                            ]);
                        } else {
                            // không có tiết học thì chỉ lấy ngày
                            DB::table('subjectdetail')->insert([
                                'studentSubjectTermId' => $studentsubjecttermid,
                                'startDay' => $startDay,
                                'endDay' => $endDay,
                            ]);
                        }
                        //return $beginDay;
                    }
                }
            }
        }
        return true;
        //return explode("đến",explode(":", explode("Từ", $rows['2']['4'])['1'])['0']);
        //return $rows;

    }

    public function parseScheduleTest($html, $username) {
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

        $rows = array_filter($rows);
        foreach ($rows as $value) {
            $listDate = explode("Từ", $value['3']);
            $listLocation = array_filter(explode("(", $value['4']));
            $arrayLocal = array();
            foreach($listLocation as $local) {
                $local1 = explode(")", $local);
                $local2 = explode(",", $local1[0]);
                foreach ($local2 as $lc) {
                    array_push($arrayLocal, $local1[1]);
                }
            }
            $index = 0;
            foreach($listDate as $date) {
                if ($date != '') {
                    $time = explode(":", $date);
                    //tách lấy ngày bắt đầu và ngày kết thúc
                    $day = $time[0];
                    $startDay = date("Y-m-d", strtotime(str_replace('/', '-',explode("đến", $day)[0])));
                    $endDay = date("Y-m-d", strtotime(str_replace('/', '-',explode("đến", $day)[1])));

                    $weekday = explode("Thứ ", $time[1]);
                    $i = 1;
                    foreach($weekday as $week) {
                        //tách lấy tiết học
                        if ($week[0] != ' ') {
                            $t = $week[0];
                            if (sizeof($weekday) > 2) {
                                $thu = array_filter(explode("[", $arrayLocal[$index]));
                                echo $startDay . ' ' . $endDay . ' ' . $t . ' ' . explode("] ", $thu[$i])[1];
                                $i++;
                            } else {
                                echo $startDay . ' ' . $endDay . ' ' . $t . ' ' . $arrayLocal[$index];
                            }
                            if (str_contains($week, '1,2,3')) {
                                $ca = '1';
                                echo ' ' . $ca;
                            } else if (str_contains($week, '4,5,6')) {
                                $ca = '2';
                                echo ' ' . $ca;
                            } else if (str_contains($week, '7,8,9')) {
                                $ca = '3';
                                echo ' ' . $ca;
                            } else if (str_contains($week, '10,11,12')) {
                                $ca = '4';
                                echo ' ' . $ca;
                            }
                            echo "\n";
                        }

                    }
                    $index++;
                }
            }
            return 'ok';
        }

    }

    // tách lấy dữ liệu lịch thi
    public function parseExam($html) {
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
        return $rows;
    }

    //request lấy lịch học
    public function getAllSchedule(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'Reports/Form/StudentTimeTable.aspx';


        $termValue = DB::table('term')->where('termName', '=', '2_2020_2021')->value('termValue');
        $html = $login->getScheduleHTML($username, $password, $page, $termValue);
        return $this->parseScheduleTest($html, $username);
    }

    //request lấy lịch thi
    public function getExamSchedule(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentViewExamList.aspx';

        $termValue = DB::table('term')->where('termName', '=', '1_2022_2023')->value('termValue');
        $html = $login->getExamHTML($username, $password, $page, $termValue);
        return $this->parseExam($html);
    }

    //lấy lịch học theo msv
    public function getScheduleByUsername($username) {
        $studentTermId = DB::table('studentterm')->where('studentId', $username)->value('studentTermId');
        $allStudentSubjectTermId = DB::table('studentsubjectterm')->where('studentTermId', $studentTermId)->get();
        $arr = json_decode($allStudentSubjectTermId, true);
        $studentSubjectTermIds = array();

        foreach ($arr as $item) {
            $studentSubjectTermIds[] = $item['studentSubjectTermId'];
            $allSubjectDetail[] = DB::table('subjectdetail')->where('studentSubjectTermId', $item['studentSubjectTermId'])->get();
        }
        // return json_encode($allSubjectDetail[0]);
        $jsonArray = [];

        foreach ($allSubjectDetail as $innerArray) {
            foreach ($innerArray as $jsonObject) {
                array_push($jsonArray, $jsonObject);
            }
        }
        return $jsonArray;
    }

    //lấy lịch học theo msv
    public function fetchSchedule($username) {
        $query = "select studentmodule.moduleId, m.moduleName, m.moduleCredit , studentmodule.times, t.DQT, t.THI, t.TKHP FROM studentmodule JOIN times t ON studentmodule.studentModuleId = t.studentModuleId JOIN module m ON studentmodule.moduleId = m.moduleId WHERE studentId=$username";
        return DB::table('studentterm')
        ->join('studentsubjectterm', 'studentterm.studentTermId', '=', 'studentsubjectterm.studentTermId')
        ->join('subjectdetail', 'studentsubjectterm.studentSubjectTermId', '=', 'subjectdetail.studentSubjectTermId')
        ->join('subject', 'subject.subjectId', '=', 'studentsubjectterm.subjectId')
        ->where('studentterm.studentId', '=', $username)
        ->get();
    }
}
