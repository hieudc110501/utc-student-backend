<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;


class LoginController extends Controller
{

    // post login
    public function postLogin(Request $request) {
        $client = new Client();
        $jar = new CookieJar();
        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';

        $username = $request->input('username');
        $password = $request->input('password');

        $response = $client->request('POST' ,$loginUrl, [
            'form_params' => [
                'txtUserName' => $username,
                'txtPassword' => md5($password),
                'btnSubmit' => "%C4%90%C4%83ng+nh%E1%BA%ADp",
                '__EVENTVALIDATION' => "/wEdAA+EHO7N6aPIzoaR/wcuJOqUb8csnTIorMPSfpUKU79Fa8zr1tijm/dVbgMI0MJ/5MgoRSoZPLBHamO4n2xGfGAWHW/isUyw6w8trNAGHDe5T/w2lIs9E7eeV2CwsZKam8yG9tEt/TDyJa1fzAdIcnRuY3plgk0YBAefRz3MyBlTcHY2+Mc6SrnAqio3oCKbxYY85pbWlDO2hADfoPXD/5tdAxTm4XTnH1XBeB1RAJ3owlx3skko0mmpwNmsvoT+s7J0y/1mTDOpNgKEQo+otMEzMS21+fhYdbX7HjGORawQMqpdNpKktwtkFUYS71DzGv6QIlKO9YFTHRffdxlgVifnYzxfYzhgfCyufPt/QB+rpg==",
                '__VIEWSTATE' => "/wEPDwUKMTkwNDg4MTQ5MQ9kFgICAQ9kFgpmD2QWCgIBDw8WAh4EVGV4dAUuSOG7hiBUSOG7kE5HIFRIw5RORyBUSU4gVFLGr+G7nE5HIMSQ4bqgSSBI4buMQ2RkAgIPZBYCZg8PFgQfAAUNxJDEg25nIG5o4bqtcB4QQ2F1c2VzVmFsaWRhdGlvbmhkZAIDDxAPFgYeDURhdGFUZXh0RmllbGQFBmt5aGlldR4ORGF0YVZhbHVlRmllbGQFAklEHgtfIURhdGFCb3VuZGdkEBUBAlZOFQEgQUU1NjE5NjI2OUFGNDQ3NkI0MjIwNjdDOUI0MjQ1MDQUKwMBZxYBZmQCBA8PFgIeCEltYWdlVXJsBSgvQ01DU29mdC5JVS5XZWIuSW5mby9JbWFnZXMvVXNlckluZm8uZ2lmZGQCBQ9kFgYCAQ8PFgIfAAUGS2jDoWNoZGQCAw8PFgIfAGVkZAIHDw8WAh4HVmlzaWJsZWhkZAICD2QWBAIDDw9kFgIeBm9uYmx1cgUKbWQ1KHRoaXMpO2QCBw8PFgIfAGVkZAIEDw8WAh8GaGRkAgYPDxYCHwZoZBYGAgEPD2QWAh8HBQptZDUodGhpcyk7ZAIFDw9kFgIfBwUKbWQ1KHRoaXMpO2QCCQ8PZBYCHwcFCm1kNSh0aGlzKTtkAgsPZBYIZg8PFgIfAAUJRW1wdHlEYXRhZGQCAQ9kFgJmDw8WAh8BaGRkAgIPZBYCZg8PFgQfAAUNxJDEg25nIG5o4bqtcB8BaGRkAgMPDxYCHwAFtgU8YSBocmVmPSIjIiBvbmNsaWNrPSJqYXZhc2NyaXB0OndpbmRvdy5wcmludCgpIj48ZGl2IHN0eWxlPSJGTE9BVDpsZWZ0Ij4JPGltZyBzcmM9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL2ltYWdlcy9wcmludC5wbmciIGJvcmRlcj0iMCI+PC9kaXY+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdDtQQURESU5HLVRPUDo2cHgiPkluIHRyYW5nIG7DoHk8L2Rpdj48L2E+PGEgaHJlZj0ibWFpbHRvOj9zdWJqZWN0PUhlIHRob25nIHRob25nIHRpbiBJVSZhbXA7Ym9keT1odHRwczovL3FsZHQudXRjLmVkdS52bi9DTUNTb2Z0LklVLldlYi5pbmZvL2xvZ2luLmFzcHgiPjxkaXYgc3R5bGU9IkZMT0FUOmxlZnQiPjxpbWcgc3JjPSIvQ01DU29mdC5JVS5XZWIuSW5mby9pbWFnZXMvc2VuZGVtYWlsLnBuZyIgIGJvcmRlcj0iMCI+PC9kaXY+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdDtQQURESU5HLVRPUDo2cHgiPkfhu61pIGVtYWlsIHRyYW5nIG7DoHk8L2Rpdj48L2E+PGEgaHJlZj0iIyIgb25jbGljaz0iamF2YXNjcmlwdDphZGRmYXYoKSI+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdCI+PGltZyBzcmM9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL2ltYWdlcy9hZGR0b2Zhdm9yaXRlcy5wbmciICBib3JkZXI9IjAiPjwvZGl2PjxkaXYgc3R5bGU9IkZMT0FUOmxlZnQ7UEFERElORy1UT1A6NnB4Ij5UaMOqbSB2w6BvIMawYSB0aMOtY2g8L2Rpdj48L2E+ZGRkW1oHE138fDuSGwXsAiQ0c74mVrZo63w+QOY04yoBClg=",
            ],
            'cookies' => $jar
        ]);
        //return  $response->getBody();
        $crawler = new Crawler($response->getBody());
        $fullname = $crawler->filter('#PageHeader1_lblUserFullName')->text();
        if ($fullname == 'Khách') {
            return false;
        } else {
            return true;
        }

    }

    //get session
    public function getSessionId() {
        $headers = get_headers('https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info/Login.aspx', 1);
        $sessionId = explode('/', $headers['Location'])[2];
        return $sessionId;
    }

    //get cookie
    public function getCookie($username, $password, $loginUrl)
    {
        $client = new Client();
        $jar = new CookieJar();

        $client->request('POST' ,$loginUrl, [
            'form_params' => [
                'txtUserName' => $username,
                'txtPassword' => md5($password),
                'btnSubmit' => "%C4%90%C4%83ng+nh%E1%BA%ADp",
                '__EVENTVALIDATION' => "/wEdAA+EHO7N6aPIzoaR/wcuJOqUb8csnTIorMPSfpUKU79Fa8zr1tijm/dVbgMI0MJ/5MgoRSoZPLBHamO4n2xGfGAWHW/isUyw6w8trNAGHDe5T/w2lIs9E7eeV2CwsZKam8yG9tEt/TDyJa1fzAdIcnRuY3plgk0YBAefRz3MyBlTcHY2+Mc6SrnAqio3oCKbxYY85pbWlDO2hADfoPXD/5tdAxTm4XTnH1XBeB1RAJ3owlx3skko0mmpwNmsvoT+s7J0y/1mTDOpNgKEQo+otMEzMS21+fhYdbX7HjGORawQMqpdNpKktwtkFUYS71DzGv6QIlKO9YFTHRffdxlgVifnYzxfYzhgfCyufPt/QB+rpg==",
                '__VIEWSTATE' => "/wEPDwUKMTkwNDg4MTQ5MQ9kFgICAQ9kFgpmD2QWCgIBDw8WAh4EVGV4dAUuSOG7hiBUSOG7kE5HIFRIw5RORyBUSU4gVFLGr+G7nE5HIMSQ4bqgSSBI4buMQ2RkAgIPZBYCZg8PFgQfAAUNxJDEg25nIG5o4bqtcB4QQ2F1c2VzVmFsaWRhdGlvbmhkZAIDDxAPFgYeDURhdGFUZXh0RmllbGQFBmt5aGlldR4ORGF0YVZhbHVlRmllbGQFAklEHgtfIURhdGFCb3VuZGdkEBUBAlZOFQEgQUU1NjE5NjI2OUFGNDQ3NkI0MjIwNjdDOUI0MjQ1MDQUKwMBZxYBZmQCBA8PFgIeCEltYWdlVXJsBSgvQ01DU29mdC5JVS5XZWIuSW5mby9JbWFnZXMvVXNlckluZm8uZ2lmZGQCBQ9kFgYCAQ8PFgIfAAUGS2jDoWNoZGQCAw8PFgIfAGVkZAIHDw8WAh4HVmlzaWJsZWhkZAICD2QWBAIDDw9kFgIeBm9uYmx1cgUKbWQ1KHRoaXMpO2QCBw8PFgIfAGVkZAIEDw8WAh8GaGRkAgYPDxYCHwZoZBYGAgEPD2QWAh8HBQptZDUodGhpcyk7ZAIFDw9kFgIfBwUKbWQ1KHRoaXMpO2QCCQ8PZBYCHwcFCm1kNSh0aGlzKTtkAgsPZBYIZg8PFgIfAAUJRW1wdHlEYXRhZGQCAQ9kFgJmDw8WAh8BaGRkAgIPZBYCZg8PFgQfAAUNxJDEg25nIG5o4bqtcB8BaGRkAgMPDxYCHwAFtgU8YSBocmVmPSIjIiBvbmNsaWNrPSJqYXZhc2NyaXB0OndpbmRvdy5wcmludCgpIj48ZGl2IHN0eWxlPSJGTE9BVDpsZWZ0Ij4JPGltZyBzcmM9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL2ltYWdlcy9wcmludC5wbmciIGJvcmRlcj0iMCI+PC9kaXY+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdDtQQURESU5HLVRPUDo2cHgiPkluIHRyYW5nIG7DoHk8L2Rpdj48L2E+PGEgaHJlZj0ibWFpbHRvOj9zdWJqZWN0PUhlIHRob25nIHRob25nIHRpbiBJVSZhbXA7Ym9keT1odHRwczovL3FsZHQudXRjLmVkdS52bi9DTUNTb2Z0LklVLldlYi5pbmZvL2xvZ2luLmFzcHgiPjxkaXYgc3R5bGU9IkZMT0FUOmxlZnQiPjxpbWcgc3JjPSIvQ01DU29mdC5JVS5XZWIuSW5mby9pbWFnZXMvc2VuZGVtYWlsLnBuZyIgIGJvcmRlcj0iMCI+PC9kaXY+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdDtQQURESU5HLVRPUDo2cHgiPkfhu61pIGVtYWlsIHRyYW5nIG7DoHk8L2Rpdj48L2E+PGEgaHJlZj0iIyIgb25jbGljaz0iamF2YXNjcmlwdDphZGRmYXYoKSI+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdCI+PGltZyBzcmM9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL2ltYWdlcy9hZGR0b2Zhdm9yaXRlcy5wbmciICBib3JkZXI9IjAiPjwvZGl2PjxkaXYgc3R5bGU9IkZMT0FUOmxlZnQ7UEFERElORy1UT1A6NnB4Ij5UaMOqbSB2w6BvIMawYSB0aMOtY2g8L2Rpdj48L2E+ZGRkW1oHE138fDuSGwXsAiQ0c74mVrZo63w+QOY04yoBClg=",
            ],
            'cookies' => $jar
        ]);
        return $jar->toArray()[0]["Value"];
    }

    //get html
    public function getHTML($username, $password, $page) {
        $client = new Client();

        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';
        $url = $originUrl . '/' . $this->getSessionId() . '/' . $page;

        $cookie = $this->getCookie($username, $password, $loginUrl);
        $response = $client->request('GET', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn='. $cookie,
            ]
        ]);
        return $response->getBody();
    }

    public function getExamHTML($username, $password, $page, $termValue) {
        $client = new Client();

        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';
        $url = $originUrl . '/' . $this->getSessionId() . '/' . $page;

        $cookie = $this->getCookie($username, $password, $loginUrl);
        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn='. $cookie,
            ],
            'form_params' => [
                '__EVENTTARGET' => 'drpSemester',
                '__EVENTVALIDATION' => "/wEdADoTknsv2lp4kp4XNSjadyiub8csnTIorMPSfpUKU79Fa8zr1tijm/dVbgMI0MJ/5MgoRSoZPLBHamO4n2xGfGAWHW/isUyw6w8trNAGHDe5T/w2lIs9E7eeV2CwsZKam8yG9tEt/TDyJa1fzAdIcnRuq940A0sVd2nflhG7GplI5+8XeUh3gRTV1fmhPau35QRJEm+/71JNhmPUTYDle8ZOHzXt/wo/gAXdH61nlPtF37RzoLCMqMLjhB1fK7JOkgin1Tr6fWaJEkN00OBzDS8+0wELA3kdDn4JdbaOdxdL8whyGMVh9kITG1BDXj6a5TlE/QtRwXNHmi9bU0C06mfey7O8k7FAqL9PO1hAA4oBejLReS2jMosUKgC/eTPbuURSPXch3PO5n4Q7iWBVtTULXCwfKLoYIMsi5Vgh+NDQHqkAIA3tIFmcw4vortGlP3dNasOXpl4dRdUYqOaUC66x0qa6e0CKDbAWr4153wt/c53EkWxBXpJw7CNMnfNAU5Bbu6IY1qNTRxofYDLh6qwHEg5fyo/kW5NyhXZKYHIAy/uZonhaNE6/s4Lwvncn9AQqygea7fEd1El079dMI+BR7PbV5UytaeCakw3IEDD3SD3YPaUYo164y+npFwiWi+BkoNDL8Fzow4O3SA7djGIQanv4jOdDFZ3smhb0mDYS6T2rxEjOZ4Uyf26iVCXR5R51nDUECGa3pa1xZeiI3b/3qA9nZ7dMsRxGja+88ge382rZHRqnErLh8ovQrmTDWdyrPx6ZuzsPZyD65wCnlAtmPg8NeeOkeaVPN533ZxoaBVWOWet3vbyfbpRW9nAl+Fl21voHivU7xYLX+mWAfz4HYCQJNS6gT62lE2x/MBNdMFh8JBLrCoKMaEs4LBsPO90qkh+OC/230esp9ky36bQwA86TM7J3x6DCl0fqrhthU19qSJ8RHeMXNoZvq7dFLOW5gXTeVq5L3iqURU/GNKPJW69HfVHjxqNtBpSXdyajYQiGuPyhkmYVE7L10B+y2ClWf65pZlwSJTtA+CVVm0wi7PQysZBynTeKqZ1pA4czgHs7nD5doR9Ilon20avH5sFXr3T5Y7/s5/yEKdh2PsSxC2/XN0nAHO2olVFCV4odLXDMYv/zgs/meZjhaGPqLRsMRdvMnsEUpdIdQiYxbtjg1uzEySjeA1Pc2tLEo6eorjEttfn4WHW1+x4xjkWsEDKqXTaSpLcLZBVGEu9Q8xr+ZvsSO/y4WgYsYalzA2pS1LEDQ3BVtTJ6JH8K04gfdVs=",
                '__VIEWSTATE' => "/wEPDwUJNTQ5MzM5MzA3D2QWAgIBD2QWHAIBD2QWDAIBDw8WAh4EVGV4dAUuSOG7hiBUSOG7kE5HIFRIw5RORyBUSU4gVFLGr+G7nE5HIMSQ4bqgSSBI4buMQ2RkAgIPZBYCZg8PFgQfAAUGVGhvw6F0HhBDYXVzZXNWYWxpZGF0aW9uaGRkAgMPEA8WBh4NRGF0YVRleHRGaWVsZAUGa3loaWV1Hg5EYXRhVmFsdWVGaWVsZAUCSUQeC18hRGF0YUJvdW5kZ2QQFQECVk4VASBBRTU2MTk2MjY5QUY0NDc2QjQyMjA2N0M5QjQyNDUwNBQrAwFnFgFmZAIEDw8WAh4ISW1hZ2VVcmwFKC9DTUNTb2Z0LklVLldlYi5JbmZvL0ltYWdlcy9Vc2VySW5mby5naWZkZAIFD2QWCAIBDw8WAh8ABR9UcsawxqFuZyBNaW5oIEhp4bq/dSgxOTEyMDM2NTkpZGQCBQ8PFgIfAAUKU2luaCB2acOqbmRkAgcPDxYCHgdWaXNpYmxlaGRkAgkPDxYCHwAFEEjhu5lwIHRpbiBuaOG6r25kZAIHDw8WAh8ABY8BxJDEg25nIGvDvSB0aGkgPHNwYW4gc3R5bGU9ImZvbnQtc2l6ZToxMHB4Ij4+PC9zcGFuPiA8YSBocmVmPSIvQ01DU29mdC5JVS5XZWIuSW5mby9TdHVkZW50Vmlld0V4YW1MaXN0LmFzcHgiPlRyYSBj4bupdSBs4buLY2ggdGhpIGPDoSBuaMOibjwvYT5kZAIDD2QWAmYPDxYCHwFoZGQCBQ9kFgJmDw8WBB8ABQZUaG/DoXQfAWhkZAIHDw8WAh8ABQkxOTEyMDM2NTlkZAIJDw8WAh8ABRRUcsawxqFuZyBNaW5oIEhp4bq/dWRkAgsPDxYCHwAFA0s2MGRkAg0PDxYCHwAFF0PDtG5nIG5naOG7hyB0aMO0bmcgdGluZGQCDw8PFgIfAAUdQ8O0bmcgbmdo4buHIHRow7RuZyB0aW4gIDYgNjBkZAIRDxAPFgYfAgUIU2VtZXN0ZXIfAwUCSWQfBGdkEBUjCzJfMjAyM18yMDI0CzFfMjAyM18yMDI0CzJfMjAyMl8yMDIzCzFfMjAyMl8yMDIzCzJfMjAyMV8yMDIyCzFfMjAyMV8yMDIyCzJfMjAyMF8yMDIxCzFfMjAyMF8yMDIxCzJfMjAxOV8yMDIwCzFfMjAxOV8yMDIwCzJfMjAxOF8yMDE5CzFfMjAxOF8yMDE5CzJfMjAxN18yMDE4CzFfMjAxN18yMDE4CzJfMjAxNl8yMDE3CzFfMjAxNl8yMDE3CzNfMjAxNV8yMDE2CzJfMjAxNV8yMDE2CzFfMjAxNV8yMDE2CzNfMjAxNF8yMDE1CzJfMjAxNF8yMDE1CzFfMjAxNF8yMDE1CzJfMjAxM18yMDE0CzFfMjAxM18yMDE0CzJfMjAxMl8yMDEzCzFfMjAxMl8yMDEzCzJfMjAxMV8yMDEyCzFfMjAxMV8yMDEyCzJfMjAxMF8yMDExCzFfMjAxMF8yMDExCzJfMjAwOV8yMDEwCzFfMjAwOV8yMDEwCzJfMjAwOF8yMDA5CzFfMjAwOF8yMDA5CzFfMjAwNl8yMDA3FSMgZjNlNWJmMzkwOWE5NGU1YWExMGVjMTEzYWY0YjJjYWQgYzIyZWVlM2YwOGI0NDdiYzhmMmI0NmI4ZDFhMTI4ZjQgOTU5RDE3MzBBNjFBNDMxQThGQTc1MjEwMzEyMzNBRUUgNzdhZWE2Mjc2MGUyNDhlZGJmZDQzOWFkYWUwYTk0NTQgOWRlMzcwMDgwMTQzNGEzOTk2NDQxNTUwYzQ0ZGQ4ZTAgMWZiZmJkYjQzMzkzNGVmNDhiNWRmMTUwZDYzYTY5MGIgZDU4ODQxMDBmM2U1NDQxY2E4YzQzNjEzOWMxOTRiODEgYmY5MGUxYmRiNjRkNDA1NGI5ZWFkYWI0ZjUwNGQ3MGQgNjA5NDQ3MkM2NjlGNERBQkE0QjM3QjBCMjRDNUZDRTIgZDBjOTdhOWY5YWU0NDA1YmE5ZDRhMTI4NGNmN2YwNDIgOWY4ZjU3NTBhNGViNDY5YjgxODEzNjNkODQxOTU2OTAgZThkYzYyNmE3OTAwNGRmZjkwZTU0ZDFiYjM5MjRlY2UgRjlDOUM0MEI3RENFNDBDQ0I4MEI1MzMzRUE2M0M1QUUgNGE0MWY2MWI1M2ZhNDAxNGJmZTlmZjljNmRmNzlhZGIgY2E1OTlkODVmMWEzNGQwOTllYWE2YjYyNDcyNmJkMzQgMmNmODVmOGUyNTY1NDU4MzkyNTgwYzhhMmMzMmRlZTQgNjEzN2YwOWI2MTE5NGQ1YWIzMzBkMzkyMzUxZTUwZmEgOGRiOGU5ODc2ZTFiNDU3NGJlMTZkMGM4YjhlYmIyOGYgZjlkYWRhMjc0Yzg3NDhjM2E5OWQzZDQ2NGFjYzIwZjEgMTQ5M2IzNzU3ZGUxNDg0Mzg1ZGUyNjA3ZGI5YmJiODEgNUI3ODEwQjU5NEI1NEU5QkI2NDBFQzMyNkM2RkVBRjIgZDY3MDYzZmRlN2NiNGZlYWJlNjY1MGIzNDAxZDgxNDggMjliNjVlMzNiYTliNDZjYzllMWYwNTM1OTI3YWMzOTcgNzkxZDEzODZkZDc3NDQ4YWI5ZjQ0Yjk2NmZhYTk5NmQgZGIyYWM3NDM4YjE4NDg1ODg4ZDdhZjEwMmY2MGMxYmEgODViMWI4ZGY5NzNhNGVhNmE3MzYzOWI0MzlhYjIzYjAgYTdiODMxOTNmYzkxNDlhNzgwZjE0NGRhMDAyN2MxYWEgOTAwMWE4ZDdlNjBmNDM1NjljNTA5N2Q1MTA1MzRhNTMgNmNmYjE1ZWExZGYxNDQ2NGFlNjVlNTc1YWUyMmI5NzIgOGY4YjY3ZDZhZTE3NDk2YjljYWYwNDM1Njg4MzQ1M2EgOWI0OWIyY2QyZmYwNDE4Njg5ZGVkYjJhZjY3NWNhYmEgNjBkYWJhODg3MjU1NGRmZTg4OGVhNzhmYTg0NmY5MzQgMDAxMDBhZDQ0OTY2NGU4YTg4NzkzNTIyMGE2YWRmMmEgNTdGMTMxNTEyM0EyNDYzOUJEQzgxRUMxMjg0NDNGNUUgYWMzZGU5ZWY4NTVhNDM5ZGIyNTVmZjA3OTA0YjZmYTEUKwMjZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2cWAQICZAITDxAPFgYfAgUGRXNOYW1lHwMFDkV4YW1TY2hlZHVsZUlkHwRnZBAVAQMtLS0VAQAUKwMBZxYBZmQCFQ8QZGQWAWZkAiUPFgIeC18hSXRlbUNvdW50ZmQCJw8PFgIfAGVkZAIpD2QWCGYPDxYCHwAFCUVtcHR5RGF0YWRkAgEPZBYCZg8PFgIfAWhkZAICD2QWAmYPDxYEHwAFBlRob8OhdB8BaGRkAgMPDxYCHwAFxAU8YSBocmVmPSIjIiBvbmNsaWNrPSJqYXZhc2NyaXB0OndpbmRvdy5wcmludCgpIj48ZGl2IHN0eWxlPSJGTE9BVDpsZWZ0Ij4JPGltZyBzcmM9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL2ltYWdlcy9wcmludC5wbmciIGJvcmRlcj0iMCI+PC9kaXY+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdDtQQURESU5HLVRPUDo2cHgiPkluIHRyYW5nIG7DoHk8L2Rpdj48L2E+PGEgaHJlZj0ibWFpbHRvOj9zdWJqZWN0PUhlIHRob25nIHRob25nIHRpbiBJVSZhbXA7Ym9keT1odHRwczovL3FsZHQudXRjLmVkdS52bi9DTUNTb2Z0LklVLldlYi5JbmZvL1N0dWRlbnRWaWV3RXhhbUxpc3QuYXNweCI+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdCI+PGltZyBzcmM9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL2ltYWdlcy9zZW5kZW1haWwucG5nIiAgYm9yZGVyPSIwIj48L2Rpdj48ZGl2IHN0eWxlPSJGTE9BVDpsZWZ0O1BBRERJTkctVE9QOjZweCI+R+G7rWkgZW1haWwgdHJhbmcgbsOgeTwvZGl2PjwvYT48YSBocmVmPSIjIiBvbmNsaWNrPSJqYXZhc2NyaXB0OmFkZGZhdigpIj48ZGl2IHN0eWxlPSJGTE9BVDpsZWZ0Ij48aW1nIHNyYz0iL0NNQ1NvZnQuSVUuV2ViLkluZm8vaW1hZ2VzL2FkZHRvZmF2b3JpdGVzLnBuZyIgIGJvcmRlcj0iMCI+PC9kaXY+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdDtQQURESU5HLVRPUDo2cHgiPlRow6ptIHbDoG8gxrBhIHRow61jaDwvZGl2PjwvYT5kZGSaRO56WlXHcsikFNH3ssn1fIY5/b4XqxWzOHrfoPxxNw==",
                'drpSemester' => $termValue,
            ],
        ]);
        return $response->getBody();
    }


    public function getScheduleHTML($username, $password, $page, $termValue) {
        $client = new Client();

        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';
        $url = $originUrl . '/' . $this->getSessionId() . '/' . $page;

        $cookie = $this->getCookie($username, $password, $loginUrl);
        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn='. $cookie,
            ],
        ]);

        $crawler = new Crawler($response->getBody());
        $viewstate = $crawler->filter('#__VIEWSTATE')->attr('value');
        $eventvalidation = $crawler->filter('#__EVENTVALIDATION')->attr('value');
        $hidXetHeSoHocPhiTheoDoiTuong = $crawler->filter('#hidXetHeSoHocPhiTheoDoiTuong')->attr('value');
        $hidTuitionFactorMode = $crawler->filter('#hidTuitionFactorMode')->attr('value');
        $hidLoaiUuTienHeSoHocPhi = $crawler->filter('#hidLoaiUuTienHeSoHocPhi')->attr('value');
        $hidStudentId = $crawler->filter('#hidStudentId')->attr('value');

        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn='. $cookie,
            ],
            'form_params' => [
                '__EVENTTARGET' => 'drpSemester',
                '__EVENTVALIDATION' => $eventvalidation,
                '__VIEWSTATE' => $viewstate,
                'drpSemester' => $termValue,
                'hidXetHeSoHocPhiTheoDoiTuong' => $hidXetHeSoHocPhiTheoDoiTuong,
                'hidTuitionFactorMode' => $hidTuitionFactorMode,
                'hidLoaiUuTienHeSoHocPhi' => $hidLoaiUuTienHeSoHocPhi,
                'hidStudentId' => $hidStudentId,
            ]
        ]);
        return $response->getBody();
    }

}

?>
