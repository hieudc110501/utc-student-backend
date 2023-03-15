<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class TuitionController extends Controller
{
    public function parseTuitionPaid($html) {
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
        return $rows;
    }

    public function parseTuitionTotalDueAmount($html) {
        $crawler = new Crawler($html);
        $rows = $crawler->filter('#tblTotalDueAmount tr')->each(function ($row, $i) {
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

    public function getTuitionPaid(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentService/StudentTuitionv2.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseTuitionPaid($html);
    }

    public function getTuitionTotalDueAmount(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentService/StudentTuitionv2.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseTuitionTotalDueAmount($html);
    }
}
