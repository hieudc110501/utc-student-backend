<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

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
        return [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'gender' => $gender,
            'studentId' => $studentId,
            'studentBankAccount' => $studentBankAccount,
            'identityCard' => $identityCard,
            'identityCard' => $identityCard,
            'birth' => $birth,
            'bornIn' => $bornIn,
            'tel' => $tel,
            'email' => $email,
        ];
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
