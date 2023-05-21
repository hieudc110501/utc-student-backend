<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Carbon;

class StudentController extends Controller
{
    public function parseStudentData($html, $username, $sync)
    {

        $crawler = new Crawler($html);
        $firstName = $crawler->filter('input[name=txtHoDem]')->attr('value');
        $lastName = $crawler->filter('input[name=txtTen]')->attr('value');
        $gender = $crawler->filterXPath('//select[@name="drpGioiTinh"]')->first()->filter('option[selected]')->text();
        $studentId = $crawler->filter('input[name=txtMaSV]')->attr('value');
        $studentBankAccount = $crawler->filter('input[name=txtSoTaiKhoanNganHang]')->attr('value');
        $identityCard = $crawler->filter('input[name=txtCMTND]')->attr('value');
        $birth  = $crawler->filter('input[name=txtNgaySinh]')->attr('value');
        $bornIn = $crawler->filter('input[name=txtNoiSinh]')->attr('value');
        $tel = $crawler->filter('input[name=txtDienThoaiCaNHAN]')->attr('value');
        $email = $crawler->filter('input[name=txtEmail]')->attr('value');
        //$rows = array_filter($rows);

        $date = DateTime::createFromFormat('d/m/Y', $birth);
        $date_formatted = $date->format('Y-m-d');


        $get = DB::table('student')->where('studentId', '=', $username)->get();
        if ($get->isEmpty()) {
            $check = DB::table('student')->insert([
                'studentId' => $studentId,
                'studentName' => $firstName . ' ' . $lastName,
                'bankAccount' => $studentBankAccount,
                'identity' => $identityCard,
                'birth' => $date_formatted,
                'tel' => $tel,
                'bornIn' => $bornIn,
                'email' => $email,
                'gender' => $gender,
                'updateAt' => Carbon::now()->format('Y-m-d'),
                'sync' => $sync,
            ]);
            if ($check) {
                return response()->json(null, 204);
            } else {
                return response()->json(null, 400);
            }
        }

        $check = DB::table('student')
            ->where('studentId', $username)
            ->update([
                'studentName' => $firstName . ' ' . $lastName,
                'bankAccount' => $studentBankAccount,
                'identity' => $identityCard,
                'birth' => $date_formatted,
                'tel' => $tel,
                'bornIn' => $bornIn,
                'email' => $email,
                'gender' => $gender,
                'updateAt' => Carbon::now()->format('Y-m-d'),
                'sync' => $sync,
            ]);
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }


    //insert
    public function insert(Request $request, $sync)
    {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentProfileNew/HoSoSinhVien.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseStudentData($html, $username, $sync);
    }

    //get
    public function get($username)
    {
        $check = DB::table('student')->where('studentId', '=', $username)->first();
        if ($check) {
            return response()->json($check, 200);
        } else {
            return response()->json(false, 400);
        }
    }

    //get
    public function getSync($username)
    {
        $check = DB::table('student')->where('studentId', '=', $username)->value('sync');
        if ($check) {
            $sync = $check == 1 ? true : false;
            return response()->json($sync, 200);
        } else {
            return response()->json(false, 400);
        }
    }

    //get
    public function updateSync($username, $sync)
    {
        $check = DB::table('student')
            ->where('studentId', $username)
            ->update([
                'updateAt' => Carbon::now()->format('Y-m-d'),
                'sync' => $sync,
            ]);
        if ($check) {
            return response()->json(true, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //check
    public function check($username)
    {
        $check = DB::table('student')->where('studentId', '=', $username)->get();
        if ($check) {
            if ($check->isEmpty()) {
                return response()->json(false, 200);
            } else {
                return response()->json(true, 200);
            }
        } else {
            return response()->json(false, 400);
        }
    }

    //delete
    public function delete($username)
    {
        $check = DB::table('student')->where('studentId', '=', $username)->delete();
        if ($check) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 400);
        }
    }
}
