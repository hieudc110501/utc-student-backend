<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;


class MarkController extends Controller
{

    public function parseMarkData($html) {
        $crawler = new Crawler($html);
        $rows = $crawler->filter('#grdResult tr')->each(function ($row, $i) {
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

    public function parseMarkSubjectData($html, $username) {
        $crawler = new Crawler($html);
        $rows = $crawler->filter('#tblStudentMark tr')->each(function ($row, $i) {
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
            if ($row[0] != 'STT') {
                $check = DB::table('module')->where('moduleId', $row[1])->get();
                if ($check->isEmpty()) {
                    DB::table('module')->insert([
                        'moduleId' => $row[1],
                        'moduleName' => $row[2],
                        'moduleCredit' => (int)$row[3],
                    ]);
                    $studentModuleId = DB::table('studentModule')->insertGetId([
                        'moduleId' => $row[1],
                        'studentId' => $username,
                        'times' => $row[4],
                    ]);
                    $index1 = 0;
                    $index2 = 0;
                    $index3 = 0;
                    for ($i = 0; $i < $row[4]; $i++) {
                        if (substr($row[10], $index1+1,1) == '.') {
                            $dqt = substr($row[10], $index1,3);
                            $index1 += 3;
                        } else {
                            $dqt = substr($row[10], $index1,2);
                            $index1 += 2;
                        }
                        if (substr($row[11], $index2+1,1) == '.') {
                            $thi = substr($row[11], $index2,3);
                            $index2 += 3;
                        } else {
                            $thi = substr($row[11], $index2,2);
                            $index2 += 2;
                        }
                        if (substr($row[12], $index3+1,1) == '.') {
                            $tkhp = substr($row[12], $index3,3);
                            $index3 += 3;
                        } else {
                            $tkhp = substr($row[12], $index3,2);
                            $index3 += 2;
                        }
                        DB::table('times')->insert([
                            'studentModuleId' => $studentModuleId,
                            'DQT' => (float)$dqt,
                            'THI' => (float)$thi,
                            'TKHP' => (float)$tkhp,
                        ]);
                    }
                } else {
                    //kiểm tra số lần học
                    $getTimes = $check = DB::table('studentModule')->where('moduleId', $row[1])->where('studentId', $username)->value('times');
                }
            }
        }
        return true;
    }

    public function getMark(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentMark.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseMarkData($html);
    }

    public function getSubjectMark(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentMark.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseMarkSubjectData($html, $username);
    }

    public function fetchMark($username) {
        $query = "select studentmodule.moduleId, m.moduleName, m.moduleCredit , studentmodule.times, t.DQT, t.THI, t.TKHP FROM studentmodule JOIN times t ON studentmodule.studentModuleId = t.studentModuleId JOIN module m ON studentmodule.moduleId = m.moduleId WHERE studentId=$username";
        return DB::table('module')
        ->join('studentmodule', 'studentmodule.moduleId', '=', 'module.moduleId')
        ->join('times', 'times.studentModuleId', '=', 'studentmodule.studentModuleId')
        ->where('studentId', '=', $username)
        ->get();
    }
}
