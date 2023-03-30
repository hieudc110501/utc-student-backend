<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;
use DateTime;

class StudentController extends Controller
{
    public function parseStudentData($html) {
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

        if(DB::table('student')->insert([
            'studentId' => $studentId,
            'studentName' => $firstName . ' '. $lastName,
            'bankAccount' => $studentBankAccount,
            'identity' => $identityCard,
            'birth' => $date_formatted,
            'tel' => $tel,
            'bornIn' => $bornIn,
            'email' => $email,
            'gender'=> $gender,
        ])) {
            return true;
        }
        return false;
    }

    public function getStudent(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentProfileNew/HoSoSinhVien.aspx';

        $html = $login->getHTML($username, $password, $page);
        return $this->parseStudentData($html);
    }

    public function checkLogged(Request $request) {
        $login = new LoginController();
        $username = $request->input('username');
        $password = $request->input('password');
        $page = 'StudentProfileNew/HoSoSinhVien.aspx';

        $check = DB::table('student')->where('studentId', '=', $username)->get();
        if ($check->isNotEmpty()) {
            return DB::table('student')->where('studentId', '=', $username)->first();
        }
        else {
            $html = $login->getHTML($username, $password, $page);
            if($this->parseStudentData($html)) {
                return DB::table('student')->where('studentId', '=', $username)->get();
            }
            return 'Could not load';
        }
    }
}
