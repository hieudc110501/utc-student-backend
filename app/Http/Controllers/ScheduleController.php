<?php

namespace App\Http\Controllers;
use App\Http\Controllers\LoginController;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{

    public function parseSchedule($html) {
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
            'studentId' => '191413698',
            'termId' => $rows['1']['4'],
        ]);

        // lưu các môn học ứng với từng sinh viên theo kì vào bảng
        foreach ($rows as $value) {
            if (DB::table('subject')->where('subjectName', '=', $value['1'])->first() == null) {
                $subjectId = DB::table('subject')->insertGetId([
                    'subjectName' => $value['1'],
                ]);
                echo $studentTermId . ' ' . $subjectId;
                DB::table('studentsubjectterm')->insert([
                    'studentTermId' => $studentTermId,
                    'subjectId' => $subjectId,
                ]);
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
        return $this->parseSchedule($html);
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
