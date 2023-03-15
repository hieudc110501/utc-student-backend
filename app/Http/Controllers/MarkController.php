<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;


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

    public function parseMarkSubjectData($html) {
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
        return $rows;
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
        return $this->parseMarkSubjectData($html);
    }
}
