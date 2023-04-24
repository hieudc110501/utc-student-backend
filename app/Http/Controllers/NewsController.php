<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class NewsController extends Controller
{
    public function parseNews($html) {
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
            $content = preg_replace($pattern, "", $row[0][0]);
            $content = str_replace("()", "", $content);
            $check = DB::table('news')->insert([
                'content' => $content,
                'date' => date("Y-m-d", strtotime(str_replace('/', '-',trim($date)))),
                'endpoint' => $row[0][1],
            ]);
            if (!$check) {
                return response()->json(null, 400);
            }
        }
        return response()->json(null, 204);
    }

    public function parseNewsDetail($html) {
        $crawler = new Crawler($html);
        $arr = array();
        $tieude = $crawler->filter('div.tieude')->text();
        $tomtat = $crawler->filter('div.tomtat')->text();
        $chitiet = $crawler->filter('div.chitiet')->text();

        array_push($arr, $tieude);
        array_push($arr, $tomtat);
        array_push($arr, $chitiet);
        return $arr;
    }

    public function insert(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'Home.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseNews($html, $username);
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

    public function getDetail(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $endpoint = $request->input('endpoint');
        $page = 'HomeDetail.aspx?' . $endpoint;

        $html = $login->getHTML($username, $password, $page);
        return $this->parseNewsDetail($html);
    }

}
