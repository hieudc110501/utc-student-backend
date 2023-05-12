<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;


class MarkController extends Controller
{
    public function parseMarkData($html, $username)
    {
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
        foreach ($rows as $row) {
            if ($row[1] != 'Học kỳ' && $row[1] != 'Cả Năm') {
                if ($row[0] != 'Toàn khóa') {
                    $x = explode('_', $row[0]);
                    $hk = substr($x[0], 2) . substr($x[1], 2) . $row[1];
                    $check = DB::table('gpa')->insert([
                        'studentId' => $username,
                        'term' => $hk,
                        'gpa10' => $row[2],
                        'gpa4' => $row[4],
                        'credit' => $row[12],
                    ]);
                } else {
                    $check = DB::table('gpa')->insert([
                        'studentId' => $username,
                        'term' => $row[0],
                        'gpa10' => $row[2],
                        'gpa4' => $row[4],
                        'credit' => $row[12],
                    ]);
                }
                if (!$check) {
                    return response()->json(null, 400);
                }
            }
        }
        return response()->json(null, 204);
    }

    public function parseMarkSubjectData($html, $studentTermId)
    {
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
        foreach ($rows as $row) {
            if (sizeof($row) == 13) {
                if ($row[0] != 'STT') {
                    $studentModuleId = DB::table('mark')->insertGetId([
                        'studentTermId' => $studentTermId,
                        'moduleId' => $row[1],
                        'moduleName' => $row[2],
                        'moduleCredit' => (int)$row[3],
                        'times' => $row[4],
                        'evaluate' => $row[8],
                    ]);
                    if (!$studentModuleId) {
                        return response()->json(null, 400);
                    }

                    if ($row[10] != ' ') {
                        if ($row[10][strlen($row[10]) - 2] == '.' && $row[4] > 1) {
                            $dqt = substr($row[10], strlen($row[10]) - 3, strlen($row[10]));
                        } else {
                            $dqt = $row[10];
                        }
                    }

                    if ($row[11] != ' ') {
                        if ($row[11][strlen($row[11]) - 2] == '.' && $row[4] > 1) {
                            $thi = substr($row[11], strlen($row[11]) - 3, strlen($row[11]));
                        } else {
                            $thi = $row[11];
                        }
                    }

                    if ($row[12] != ' ') {
                        if ($row[12][strlen($row[12]) - 2] == '.' && $row[4] > 1) {
                            $tkhp = substr($row[12], strlen($row[12]) - 3, strlen($row[12]));
                        } else {
                            $tkhp = $row[12];
                        }
                    }

                    $insertTime = DB::table('markDetail')->insert([
                        'markId' => $studentModuleId,
                        'dqt' => (float)$dqt,
                        'thi' => (float)$thi,
                        'tkhp' => (float)$tkhp,
                    ]);
                    if (!$insertTime) {
                        return response()->json(null, 400);
                    }
                }
            }
        }
        //return response()->json(null, 204);
    }

    // lưu tất cả điểm của các môn học
    public function insertAll(Request $request)
    {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentMark.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseMarkSubjectData($html, $username);
    }

    // lấy tất cả điểm của các môn học
    public function getAll($username)
    {
        $check = DB::table('mark')
            ->join('markDetail', 'markDetail.markId', '=', 'mark.markId')
            ->join('studentterm', 'studentterm.studenttermId', '=', 'mark.studenttermId')
            ->where('studentId', $username)
            ->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    // xóa tất cả điểm của các môn học
    public function deleteAll($username)
    {
        $listTerm = DB::table('studentterm')->where('studentId', $username)->pluck('studentTermId');
        $listModule = DB::table('mark')->whereIn('studentTermId', $listTerm)->pluck('markId');

        $check = DB::table('markDetail')->whereIn('markId', $listModule)->delete();
        $check1 = DB::table('mark')->whereIn('studentTermId', $listTerm)->delete();
        $check2 = DB::table('gpa')->where('studentId', $username)->delete();
        if ($check && $check1 && $check2) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }


    // lưu điểm theo từng kì học của từng sinh viên
    public function insertMarkTerm(Request $request)
    {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentMark.aspx';

        $listTerm = $this->getTerm($request);
        foreach ($listTerm as $term) {
            $html = $login->getMarkHTML($username, $password, $page, $term);
            $studentTermId = DB::table('studentterm')->where('studentId', $username)->where('termId', $term)->value('studentTermId');
            if ($studentTermId) {
                $this->parseMarkSubjectData($html, $studentTermId);
            } else {
                $studentTermId = DB::table('studentterm')->insertGetId([
                    'studentId' => $username,
                    'termId' => $term,
                ]);
                $this->parseMarkSubjectData($html, $studentTermId);
            }
        }
        return response()->json(null, 204);
    }

    // lấy ra những kì học của sinh viên
    public function getTerm(Request $request)
    {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentMark.aspx';

        $html = $login->getTermHTML($username, $password, $page);
        return $html;
    }

    // lấy ra điểm môn học từng kì của sinh viên
    public function getMarkByTerm(Request $request)
    {
        $username = $request->input('username');
        $termId = $request->input('termId');

        $check = DB::table('studentterm')
            ->join('mark', 'mark.studentTermId', '=', 'studentterm.studentTermId')
            ->join('markDetail', 'markDetail.markId', '=', 'mark.markId')
            ->where('studentterm.studentId', $username)
            ->where('studentterm.termId', $termId)
            ->get();

        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    // lấy ra danh sách học kì của sinh viên
    public function getAllTerm($username)
    {
        $check = DB::table('studentterm')->where('studentId', $username)->pluck('termId');
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    // lưu gpa của sinh viên
    public function insertGPA(Request $request)
    {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentMark.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseMarkData($html, $username);
    }

    // lưu gpa của sinh viên
    public function getGPA($username)
    {
        $check = DB::table('gpa')->where('studentId', $username)->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }
}
