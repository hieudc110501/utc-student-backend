<?php

namespace App\Http\Controllers;
use App\Http\Controllers\LoginController;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class ScheduleController extends Controller
{

    public function getSchedule($html) {
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
        return $rows;
    }

    public function getAllSchedule(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = $request->input('page');

        $html = $login->getHTML($username, $password, $page);
        return $this->getSchedule($html);
    }
}
