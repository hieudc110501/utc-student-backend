<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class PointController extends Controller
{
    public function parsePoint($html, $username) {
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
                $check = DB::table('point')->insert([
                    'studentId' => $username,
                    'period' => $row[1],
                    'term' => $row[2],
                    'point' => $row[3],
                    'ability' => $row[4],
                ]);
                if (!$check) {
                    return response()->json(null, 400);
                }
            } else {
                $checkstt++;
            }
        }
        return response()->json(null, 204);
    }

    public function insert(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentService/PractiseMarkAndStudyWarning.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parsePoint($html, $username);
    }

    public function get($username) {
        $check = DB::table('point')->where('studentId', $username)->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    public function delete($username) {
        $check = DB::table('point')->where('studentId', $username)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }
}
