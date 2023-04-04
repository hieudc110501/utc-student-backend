<?php

namespace App\Http\Controllers;
use App\Http\Controllers\LoginController;
use DateTime;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{

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
        //return explode("đến",explode(":", explode("Từ", $rows['2']['4'])['1'])['0']);
        //return $rows;

    }

    public function parseExam($html) {
        $crawler = new Crawler($html);
        // Find the select element with the name "hieu"
        $select = $crawler->filter('select[name="drpSemester"]')->first();

        // Find the option element with the value "123" and mark it as selected
        $select->filter('option[value="6094472C669F4DABA4B37B0B24C5FCE2"]')->first()->attr('selected', 'selected');

        var_dump($select);

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
        return $crawler->html();
    }

    public function getAllSchedule(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudyRegister/StudyRegister.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseSchedule($html, $username);
    }

    public function getExamSchedule(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentViewExamList.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $html;
        //return $this->parseExam($html);
    }
}
