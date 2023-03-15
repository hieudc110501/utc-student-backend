<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;


class MarkController extends Controller
{

    public function parseStudentData($html) {
        $crawler = new Crawler($html);
        $rows = $crawler->filter('#sinhvien')->each(function ($row, $i) {
            if ($i === 0) {
                return null;
            }

            // extract data from the row
            $cols = $row->filter('li')->each(function (Crawler $col, $j) {
                return trim($col->text());
            });
            var_dump($cols);

            // skip empty rows
            // if (empty($cols[0])) {
            //     return null;
            // }
            // return $cols;
        });
        $rows = array_filter($rows);
        return $rows;
    }

    public function getStudent(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentProfileNew/HoSoSinhVien.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseStudentData($html);
    }
}
