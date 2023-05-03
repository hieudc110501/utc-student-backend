<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class NewsController extends Controller
{
    public function parseNews($html, $username, $password) {
        $login = new LoginController();
        $crawler = new Crawler($html);
        $rows = $crawler->filter('div.important_news div')->each(function ($row, $i) {
            if ($i === 0) {
                return null;
            }
            $a = $row->filter('a')->each(function ($node) {
                $arr = array();
                array_push($arr, $node->text());
                array_push($arr, $node->attr('href'));
                return $arr;
            });
            return $a;
        });
        $rows = array_filter($rows);
        foreach($rows as $row) {
            $pattern = "/\d{2}\/\d{2}\/\d{4}/"; // Mẫu regex để tìm kiếm chuỗi có dạng dd/mm/yyyy

            if (preg_match($pattern, $row[0][0], $matches)) {
                $date = $matches[0];
            }
            $title = preg_replace($pattern, "", $row[0][0]);
            $title = str_replace("()", "", $title);
            $content = $this->getDetail($username, $password, $row[0][1]);
            $check = DB::table('news')->insert([
                'title' => $title,
                'date' => date("Y-m-d", strtotime(str_replace('/', '-',trim($date)))),
                'content' => $content,
            ]);
            if (!$check) {
                return response()->json(null, 400);
            }
        }
        return response()->json(null, 204);
    }

    public function parseNewsDetail($html) {
        $crawler = new Crawler($html);
        $chitiet = $crawler->filter('div.chitiet')->text();
        return $chitiet;
    }

    public function insert(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'Home.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseNews($html, $username, $password);
    }

    public function get() {
        $check = DB::table('news')->get();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    public function delete() {
        $check = DB::table('news')->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }

    public function getDetail($username, $password, $endpoint) {
        $login = new LoginController();
        $page = $endpoint;

        $html = $login->getHTML($username, $password, $page);
        return $this->parseNewsDetail($html);
    }

}
