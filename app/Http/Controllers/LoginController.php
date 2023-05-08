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
    public function postLogin(Request $request)
    {
        $client = new Client();
        $jar = new CookieJar();
        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';

        $username = $request->input('username');
        $password = $request->input('password');

        $response = $client->request('POST', $loginUrl, [
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
        if ($fullname != 'Khách') {
            return response()->json(true, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    //get session
    public function getSessionId()
    {
        $headers = get_headers('https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info/Login.aspx', 1);
        $sessionId = explode('/', $headers['Location'])[2];
        return $sessionId;
    }

    //get cookie
    public function getCookie($username, $password, $loginUrl)
    {
        $client = new Client();
        $jar = new CookieJar();

        $client->request('POST', $loginUrl, [
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
    public function getHTML($username, $password, $page)
    {
        $client = new Client();

        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';
        $url = $originUrl . '/' . $this->getSessionId() . '/' . $page;

        $cookie = $this->getCookie($username, $password, $loginUrl);
        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn=' . $cookie,
            ]
        ]);
        return $response->getBody();
    }

    public function getExamHTML($username, $password, $page, $termValue)
    {
        $client = new Client();

        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';
        $url = $originUrl . '/' . $this->getSessionId() . '/' . $page;

        $cookie = $this->getCookie($username, $password, $loginUrl);
        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn=' . $cookie,
            ],
        ]);

        $crawler = new Crawler($response->getBody());
        $hidStudentId = $crawler->filter('#hidStudentId')->attr('value');
        $viewstate = $crawler->filter('#__VIEWSTATE')->attr('value');
        $eventvalidation = $crawler->filter('#__EVENTVALIDATION')->attr('value');

        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn=' . $cookie,
            ],
            'form_params' => [
                '__EVENTTARGET' => 'drpSemester',
                '__EVENTVALIDATION' => $eventvalidation,
                "__VIEWSTATE" => $viewstate,
                '__VIEWSTATEGENERATOR' => 'C663F6BA',
                'drpSemester' => $termValue,
                'PageHeader1$drpNgonNgu' => 'AE56196269AF4476B422067C9B424504',
                'PageHeader1$hidisNotify' => 0,
                'hidStudentId' => $hidStudentId,
                'drpExaminationNumber' => 0,
                'hidShowShiftEndTime' => 0,
            ],
        ]);
        return $response->getBody();
    }


    public function getScheduleHTML($username, $password, $page, $termValue)
    {
        $client = new Client();

        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';
        $url = $originUrl . '/' . $this->getSessionId() . '/' . $page;

        $cookie = $this->getCookie($username, $password, $loginUrl);
        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn=' . $cookie,
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
                'Cookie' => 'SignIn=' . $cookie,
            ],
            'form_params' => [
                '__EVENTTARGET' => 'drpSemester',
                '__EVENTVALIDATION' => "/wEdAF4rji1JDoSXoa+5s9TOYtsnb8csnTIorMPSfpUKU79Fa8zr1tijm/dVbgMI0MJ/5MgoRSoZPLBHamO4n2xGfGAWHW/isUyw6w8trNAGHDe5T/w2lIs9E7eeV2CwsZKam8yG9tEt/TDyJa1fzAdIcnRuq940A0sVd2nflhG7GplI5+8XeUh3gRTV1fmhPau35QRJEm+/71JNhmPUTYDle8ZOHzXt/wo/gAXdH61nlPtF37RzoLCMqMLjhB1fK7JOkgin1Tr6fWaJEkN00OBzDS8+0wELA3kdDn4JdbaOdxdL8whyGMVh9kITG1BDXj6a5TlE/QtRwXNHmi9bU0C06mfey7O8k7FAqL9PO1hAA4oBejLReS2jMosUKgC/eTPbuURSPXch3PO5n4Q7iWBVtTULXCwfKLoYIMsi5Vgh+NDQHqkAIA3tIFmcw4vortGlP3dNasOXpl4dRdUYqOaUC66x0qa6e0CKDbAWr4153wt/c53EkWxBXpJw7CNMnfNAU5Bbu6IY1qNTRxofYDLh6qwHEg5fyo/kW5NyhXZKYHIAy/uZonhaNE6/s4Lwvncn9AQqygea7fEd1El079dMI+BR7PbV5UytaeCakw3IEDD3SD3YPaUYo164y+npFwiWi+BkoNDL8Fzow4O3SA7djGIQanv4jOdDFZ3smhb0mDYS6T2rxEjOZ4Uyf26iVCXR5R51nDUECGa3pa1xZeiI3b/3qA9nZ7dMsRxGja+88ge382rZHRqnErLh8ovQrmTDWdyrPx6ZuzsPZyD65wCnlAtmPg8NeeOkeaVPN533ZxoaBVWOWet3vbyfbpRW9nAl+Fl21voHivU7xYLX+mWAfz4HYCQJNS6gT62lE2x/MBNdMFh8JBLrCoKMaEs4LBsPO90qkh+OC/230esp9ky36bQwA86TM7J3x6DCl0fqrhthU19qSJ8RHeMXNoZvq7dFLOWQ1Hkjdwa9lIUgekx5tnvmAwRgWMA1RQTQXMaUHARvAt1jZFW4pj5GxlMTKQPimt1ZybUBexArAQtBAdH4fNKFHTQehlaxgg4l3LSQhv+Fr06gVgYEu7BgtQLt9EWkOQxF9GTGIB2EeNKmij0SI2oZHOoDL2bM7h5E722Z1f4A6aFd3B50xG2MSTAxERFF8trg7oNyt7hp5ZX6YTNW5cly4XuAolXrUt+ubfqvUe/LWSqeVniUcbNcL8CQCvHBxzhFaowOViC0KKZxjp1zAydPFvWCveX8mzzPCKKJrTODw3I/IGFseKyYadK0rTAS4xWEp4hr3XGKtijjPQOwrg/SoCnr1jN9B9w78652nwah+wr5rSRT8C63dm2nDnK7k0vyrXtjKs15JIG54vIW/oQeIRWJEBlWPASdRFwS5leEmm3Z+yRDw+vx0kC6wtZo2/lNNJTaAV2FQO8TRXsxioFkVt9+QELpx09HXAjKlBX1tUN2eoVNZ31V10eZ5Qy/m6j++ELKJpAnK+amrfvHKrQv92iea7gcseEzq9+PbIod8R1G/RbqOj/amveEdOm5zGOnrwnIbfqWVcldCHNMOzQAfi+6k7OTSWSaPpq4uiWk0nDMYv/zgs/meZjhaGPqLRt3fk5wPIlQw5ZSq0TXlIk62P+TkVweQyYaXEDnYr5JtrdPYmwsKQCD8dCbVfOflz3qPUMUnC48FqUPANWJWwcx+IxNklA+LP4pC1ddzCm0JEpebdeEVAvEVLPRwZshyyQiHMCgZk9NBcv5RrAB1Go5dMv9ZkwzqTYChEKPqLTBM9LiLTKvhW49dBymEtSD8E5tZjQWAKow8m+KVzzNSdCFpxfbe8v1j7XRuG7dW8xEKLNSXF8SolStTTcVO1KqH+WHUjfTeLkiu708Re/aY73f82Q0NQoVppEUBKHRKxztr+T0L5LbaAfpwEWCI+7IbLcjv9luheAJDwbP4Rvu9S1gntAKVOgi8aW5m3i7kB5uWzEttfn4WHW1+x4xjkWsEDKqXTaSpLcLZBVGEu9Q8xr+kH4O9GZb3iSXFWc94WHkIWgAXwT3bXxmDlvP3wOqRU8=",
                "__VIEWSTATE" => "/wEPDwUKMTUwOTAzNzUwNA9kFgICAQ9kFhwCAQ9kFgwCAQ8PFgIeBFRleHQFLkjhu4YgVEjhu5BORyBUSMOUTkcgVElOIFRSxq/hu5xORyDEkOG6oEkgSOG7jENkZAICD2QWAmYPDxYEHwAFBlRob8OhdB4QQ2F1c2VzVmFsaWRhdGlvbmhkZAIDDxAPFgYeDURhdGFUZXh0RmllbGQFBmt5aGlldR4ORGF0YVZhbHVlRmllbGQFAklEHgtfIURhdGFCb3VuZGdkEBUBAlZOFQEgQUU1NjE5NjI2OUFGNDQ3NkI0MjIwNjdDOUI0MjQ1MDQUKwMBZxYBZmQCBA8PFgIeCEltYWdlVXJsBSgvQ01DU29mdC5JVS5XZWIuSW5mby9JbWFnZXMvVXNlckluZm8uZ2lmZGQCBQ9kFggCAQ8PFgIfAAUfVHLGsMahbmcgTWluaCBIaeG6v3UoMTkxMjAzNjU5KWRkAgUPDxYCHwAFClNpbmggdmnDqm5kZAIHDw8WAh4HVmlzaWJsZWhkZAIJDw8WAh8ABRBI4buZcCB0aW4gbmjhuq9uZGQCBw8PFgIfAAWZAcSQxINuZyBrw70gaOG7jWMgPHNwYW4gc3R5bGU9ImZvbnQtc2l6ZToxMHB4Ij4+PC9zcGFuPiA8YSBocmVmPSIvQ01DU29mdC5JVS5XZWIuSW5mby9SZXBvcnRzL0Zvcm0vU3R1ZGVudFRpbWVUYWJsZS5hc3B4Ij5L4bq/dCBxdeG6oyDEkcSDbmcga8O9IGjhu41jPC9hPmRkAgQPZBYCZg9kFgICAQ8PFgIfAAUUSz90IHF1PyBkYW5nIGvDvSBoP2NkZAIGD2QWAmYPDxYCHwFoZGQCCA9kFgJmDw8WBB8ABQZUaG/DoXQfAWhkZAIKD2QWAmYPFgIeCWlubmVyaHRtbAWvEDx1bCBjbGFzcz0nc2lkZWJhci1tZW51Jz48bGkgY2xhc3M9J2hlYWRlcic+REFOSCBN4bukQyBDSMONTkg8L2xpPjxsaSBjbGFzcz0ndHJlZXZpZXcnPiA8YSBocmVmPSIvQ01DU29mdC5JVS5XZWIuSW5mby9Qcm9maWxlL0xpbmtVbmkuYXNweCI+PHNwYW4+R2lhbyBsxrB1IGvhur90IGLhuqFuPC9zcGFuPjwvYT48L2xpPjxsaT4gPGE+PGkgY2xhc3M9J2ZhIGZhLWxhcHRvcCc+PC9pPjxzcGFuPsSQxINuZyBrw70gaOG7jWM8L3NwYW4+PGkgY2xhc3M9J2ZhIGZhLWFuZ2xlLWxlZnQgcHVsbC1yaWdodCc+PC9pPjwvYT48dWwgY2xhc3M9J3RyZWV2aWV3LW1lbnUnPjxsaSBjbGFzcz0ndHJlZXZpZXcnPiA8YSBocmVmPSIvQ01DU29mdC5JVS5XZWIuaW5mby9TdHVkeVJlZ2lzdGVyL1N0dWR5UmVnaXN0ZXIuYXNweCI+U2luaCB2acOqbiDEkcSDbmcga8O9IGjhu41jPC9hPjwvbGk+PGxpIGNsYXNzPSd0cmVldmlldyc+IDxhIGhyZWY9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL1JlcG9ydHMvRm9ybS9TdHVkZW50VGltZVRhYmxlLmFzcHgiPkvhur90IHF14bqjIMSRxINuZyBrw70gaOG7jWM8L2E+PC9saT48L3VsPjwvbGk+PGxpIGNsYXNzPSd0cmVldmlldyc+IDxhIGhyZWY9Ii9DTUNTb2Z0LklVLldlYi5pbmZvL1N0dWRlbnRNYXJrLmFzcHgiPjxzcGFuPlRyYSBj4bupdSDEkWnhu4NtPC9zcGFuPjwvYT48L2xpPjxsaT4gPGE+PGkgY2xhc3M9J2ZhIGZhLWxhcHRvcCc+PC9pPjxzcGFuPsSQxINuZyBrw70gdGhpPC9zcGFuPjxpIGNsYXNzPSdmYSBmYS1hbmdsZS1sZWZ0IHB1bGwtcmlnaHQnPjwvaT48L2E+PHVsIGNsYXNzPSd0cmVldmlldy1tZW51Jz48bGkgY2xhc3M9J3RyZWV2aWV3Jz4gPGEgaHJlZj0iL0NNQ1NvZnQuSVUuV2ViLkluZm8vU3R1ZGVudFZpZXdFeGFtTGlzdC5hc3B4Ij5UcmEgY+G7qXUgbOG7i2NoIHRoaSBjw6EgbmjDom48L2E+PC9saT48bGkgY2xhc3M9J3RyZWV2aWV3Jz4gPGEgaHJlZj0iL0NNQ1NvZnQuSVUuV2ViLkluZm8vU3R1ZGVudFZpZXdSZXRha2VFeGFtUmVnaXN0cmF0aW9uLmFzcHgiPkvhur90IHF14bqjIMSRxINuZyBrw70gdGhpIGzhuqFpPC9hPjwvbGk+PC91bD48L2xpPjxsaSBjbGFzcz0ndHJlZXZpZXcnPiA8YSBocmVmPSIvQ01DU29mdC5JVS5XZWIuSW5mby9Db3Vyc2VCeUZpZWxkVHJlZS5hc3B4Ij48c3Bhbj5DaMawxqFuZyB0csOsbmggaOG7jWM8L3NwYW4+PC9hPjwvbGk+PGxpIGNsYXNzPSd0cmVldmlldyc+IDxhIGhyZWY9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL1N0dWRlbnRTZXJ2aWNlL1ByYWN0aXNlTWFya0FuZFN0dWR5V2FybmluZy5hc3B4Ij48c3Bhbj5UcmEgY+G7qXUgxJFp4buDbSByw6huIGx1eeG7h24gdsOgIHjhu60gbMO9IGjhu41jIHbhu6U8L3NwYW4+PC9hPjwvbGk+PGxpIGNsYXNzPSd0cmVldmlldyc+IDxhIGhyZWY9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL1N0dWRlbnRTZXJ2aWNlL1N0dWRlbnRUdWl0aW9udjIuYXNweCI+PHNwYW4+VHJhIGPhu6l1IHRow7RuZyB0aW4gaOG7jWMgcGjDrTwvc3Bhbj48L2E+PC9saT48bGkgY2xhc3M9J3RyZWV2aWV3Jz4gPGEgaHJlZj0iL0NNQ1NvZnQuSVUuV2ViLkluZm8vREtOVkNOL0RhbmdLeU5ndXllblZvbmdDTi5hc3B4Ij48c3Bhbj7EkMSDbmcga8O9IG5ndXnhu4duIHZvbmcgY2h1ecOqbiBuZ8Ogbmg8L3NwYW4+PC9hPjwvbGk+PGxpIGNsYXNzPSd0cmVldmlldyc+IDxhIGhyZWY9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL0VtYWlsUmVnaXN0cmF0aW9uLmFzcHgiPjxzcGFuPsSQxINuZyBrw70gxJHhu4thIGNo4buJIGVtYWlsPC9zcGFuPjwvYT48L2xpPjxsaSBjbGFzcz0ndHJlZXZpZXcnPiA8YSBocmVmPSIvQ01DU29mdC5JVS5XZWIuaW5mby9DaGFuZ2VQYXNzV29yZFN0dWRlbnQuYXNweCI+PHNwYW4+xJDhu5VpIG3huq10IGto4bqpdTwvc3Bhbj48L2E+PC9saT48bGkgY2xhc3M9J3RyZWV2aWV3Jz4gPGEgaHJlZj0iL0NNQ1NvZnQuSVUuV2ViLkluZm8vU3R1ZGVudFByb2ZpbGVOZXcvSG9Tb1NpbmhWaWVuLmFzcHgiPjxzcGFuPlNpbmggdmnDqm4geGVtIHbDoCB04buxIGPhuq1wIG5o4bqtdCAxIHPhu5EgdGjDtG5nIHRpbiBjw6EgbmjDom48L3NwYW4+PC9hPjwvbGk+PC91bD5kAgwPEA8WBh8CBQhTZW1lc3Rlch8DBQJJZB8EZ2QQFSMLMl8yMDIzXzIwMjQLMV8yMDIzXzIwMjQLMl8yMDIyXzIwMjMLMV8yMDIyXzIwMjMLMl8yMDIxXzIwMjILMV8yMDIxXzIwMjILMl8yMDIwXzIwMjELMV8yMDIwXzIwMjELMl8yMDE5XzIwMjALMV8yMDE5XzIwMjALMl8yMDE4XzIwMTkLMV8yMDE4XzIwMTkLMl8yMDE3XzIwMTgLMV8yMDE3XzIwMTgLMl8yMDE2XzIwMTcLMV8yMDE2XzIwMTcLM18yMDE1XzIwMTYLMl8yMDE1XzIwMTYLMV8yMDE1XzIwMTYLM18yMDE0XzIwMTULMl8yMDE0XzIwMTULMV8yMDE0XzIwMTULMl8yMDEzXzIwMTQLMV8yMDEzXzIwMTQLMl8yMDEyXzIwMTMLMV8yMDEyXzIwMTMLMl8yMDExXzIwMTILMV8yMDExXzIwMTILMl8yMDEwXzIwMTELMV8yMDEwXzIwMTELMl8yMDA5XzIwMTALMV8yMDA5XzIwMTALMl8yMDA4XzIwMDkLMV8yMDA4XzIwMDkLMV8yMDA2XzIwMDcVIyBmM2U1YmYzOTA5YTk0ZTVhYTEwZWMxMTNhZjRiMmNhZCBjMjJlZWUzZjA4YjQ0N2JjOGYyYjQ2YjhkMWExMjhmNCA5NTlEMTczMEE2MUE0MzFBOEZBNzUyMTAzMTIzM0FFRSA3N2FlYTYyNzYwZTI0OGVkYmZkNDM5YWRhZTBhOTQ1NCA5ZGUzNzAwODAxNDM0YTM5OTY0NDE1NTBjNDRkZDhlMCAxZmJmYmRiNDMzOTM0ZWY0OGI1ZGYxNTBkNjNhNjkwYiBkNTg4NDEwMGYzZTU0NDFjYThjNDM2MTM5YzE5NGI4MSBiZjkwZTFiZGI2NGQ0MDU0YjllYWRhYjRmNTA0ZDcwZCA2MDk0NDcyQzY2OUY0REFCQTRCMzdCMEIyNEM1RkNFMiBkMGM5N2E5ZjlhZTQ0MDViYTlkNGExMjg0Y2Y3ZjA0MiA5ZjhmNTc1MGE0ZWI0NjliODE4MTM2M2Q4NDE5NTY5MCBlOGRjNjI2YTc5MDA0ZGZmOTBlNTRkMWJiMzkyNGVjZSBGOUM5QzQwQjdEQ0U0MENDQjgwQjUzMzNFQTYzQzVBRSA0YTQxZjYxYjUzZmE0MDE0YmZlOWZmOWM2ZGY3OWFkYiBjYTU5OWQ4NWYxYTM0ZDA5OWVhYTZiNjI0NzI2YmQzNCAyY2Y4NWY4ZTI1NjU0NTgzOTI1ODBjOGEyYzMyZGVlNCA2MTM3ZjA5YjYxMTk0ZDVhYjMzMGQzOTIzNTFlNTBmYSA4ZGI4ZTk4NzZlMWI0NTc0YmUxNmQwYzhiOGViYjI4ZiBmOWRhZGEyNzRjODc0OGMzYTk5ZDNkNDY0YWNjMjBmMSAxNDkzYjM3NTdkZTE0ODQzODVkZTI2MDdkYjliYmI4MSA1Qjc4MTBCNTk0QjU0RTlCQjY0MEVDMzI2QzZGRUFGMiBkNjcwNjNmZGU3Y2I0ZmVhYmU2NjUwYjM0MDFkODE0OCAyOWI2NWUzM2JhOWI0NmNjOWUxZjA1MzU5MjdhYzM5NyA3OTFkMTM4NmRkNzc0NDhhYjlmNDRiOTY2ZmFhOTk2ZCBkYjJhYzc0MzhiMTg0ODU4ODhkN2FmMTAyZjYwYzFiYSA4NWIxYjhkZjk3M2E0ZWE2YTczNjM5YjQzOWFiMjNiMCBhN2I4MzE5M2ZjOTE0OWE3ODBmMTQ0ZGEwMDI3YzFhYSA5MDAxYThkN2U2MGY0MzU2OWM1MDk3ZDUxMDUzNGE1MyA2Y2ZiMTVlYTFkZjE0NDY0YWU2NWU1NzVhZTIyYjk3MiA4ZjhiNjdkNmFlMTc0OTZiOWNhZjA0MzU2ODgzNDUzYSA5YjQ5YjJjZDJmZjA0MTg2ODlkZWRiMmFmNjc1Y2FiYSA2MGRhYmE4ODcyNTU0ZGZlODg4ZWE3OGZhODQ2ZjkzNCAwMDEwMGFkNDQ5NjY0ZThhODg3OTM1MjIwYTZhZGYyYSA1N0YxMzE1MTIzQTI0NjM5QkRDODFFQzEyODQ0M0Y1RSBhYzNkZTllZjg1NWE0MzlkYjI1NWZmMDc5MDRiNmZhMRQrAyNnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZxYBAgRkAg4PEA8WBh8DBQRUZXJtHwIFBFRlcm0fBGdkEBUBATEVAQExFCsDAWcWAWZkAiEP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",
                'drpSemester' => $termValue,
                'hidXetHeSoHocPhiTheoDoiTuong' => $hidXetHeSoHocPhiTheoDoiTuong,
                'hidTuitionFactorMode' => $hidTuitionFactorMode,
                'hidLoaiUuTienHeSoHocPhi' => $hidLoaiUuTienHeSoHocPhi,
                'hidStudentId' => $hidStudentId,
            ]
        ]);

        return $response->getBody();
    }

    public function getMarkHTML($username, $password, $page, $termName)
    {
        $client = new Client();

        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';
        $url = $originUrl . '/' . $this->getSessionId() . '/' . $page;

        $cookie = $this->getCookie($username, $password, $loginUrl);
        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn=' . $cookie,
            ],
        ]);

        $crawler = new Crawler($response->getBody());
        $viewstate = $crawler->filter('#__VIEWSTATE')->attr('value');
        $eventvalidation = $crawler->filter('#__EVENTVALIDATION')->attr('value');
        $hidFieldId = $crawler->filter('#hidFieldId')->attr('value');
        $hidStudentId = $crawler->filter('#hidStudentId')->attr('value');

        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn=' . $cookie,
            ],
            'form_params' => [
                '__EVENTTARGET' => 'drpHK',
                '__EVENTVALIDATION' => $eventvalidation,
                '__VIEWSTATE' => $viewstate,
                'drpHK' => $termName,
                'drpField' => $hidFieldId,
                'drpFilter' => 1,
                'hidSymbolMark' => 0,
                'hidFieldId' => $hidFieldId,
                'hidStudentId' => $hidStudentId,
            ]
        ]);
        return $response->getBody();
    }

    public function getTermHTML($username, $password, $page)
    {
        $client = new Client();

        $originUrl = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info';
        $loginUrl = $originUrl . '/' . $this->getSessionId() . '/' . 'login.aspx';
        $url = $originUrl . '/' . $this->getSessionId() . '/' . $page;

        $cookie = $this->getCookie($username, $password, $loginUrl);
        $response = $client->request('POST', $url, [
            'headers' => [
                // Thêm cookie vào header của request
                'Cookie' => 'SignIn=' . $cookie,
            ],
        ]);
        $crawler = new Crawler($response->getBody());
        $select = $crawler->filter('select[name="drpHK"]')->text();

        $listOption = explode(" ", $select);
        $list = array_filter($listOption, function ($item) {
            return strlen($item) == 11;
        });
        return $list;
    }
}
