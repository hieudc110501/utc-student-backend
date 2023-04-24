<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class TuitionController extends Controller
{
    public function parseTuitionPaid($html, $username) {
        $crawler = new Crawler($html);
        $rows = $crawler->filter('#tblPaid tr')->each(function ($row, $i) {
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

        //học phí đã đóng
        $checkstt = 0;
        foreach($rows as $row) {
            if ($checkstt == 2) {
                break;
            }
            if ($row[0] != 'STT') {
                $check = DB::table('tuition')->insert([
                    'studentId' => $username,
                    'type' => $row[1],
                    'content' => $row[2],
                    'term' => $row[3],
                    'date' => date("Y-m-d", strtotime(str_replace('/', '-',trim($row[5])))),
                    'payment' => $row[6],
                    'paid' => 1,
                ]);
                if (!$check) {
                    return response()->json(null, 400);
                }
            } else {
                $checkstt++;
            }
        }

        //học phí chưa đóng
        $rows1 = $crawler->filter('#tblDueAmount tr')->each(function ($row, $i) {
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
        $rows1 = array_filter($rows1);
        $checkstt1 = 0;
        foreach($rows1 as $row) {
            if ($checkstt1 == 2) {
                break;
            }
            if ($row[0] != 'STT') {
                $check = DB::table('tuition')->insert([
                    'studentId' => $username,
                    'type' => $row[1],
                    'term' => $row[2],
                    'payment' => $row[4],
                    'paid' => 0,
                ]);
                if (!$check) {
                    return response()->json(null, 400);
                }
            } else {
                $checkstt1++;
            }
        }
        return response()->json(null, 204);
    }

    public function insert(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentService/StudentTuitionv2.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseTuitionPaid($html, $username);
    }

    public function get($username) {
        $check = DB::table('tuition')->where('studentId', $username)->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    public function delete($username) {
        $check = DB::table('tuition')->where('studentId', $username)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }
}
