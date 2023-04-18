<?php



    $string1 = 'Từ 16/09/2019 đến 16/11/2019: (1)
    Thứ 6 tiết 4,5,6 (LT)
 Từ 18/11/2019 đến 23/11/2019: (2)
    Thứ 2 tiết 7,8,9 (LT)
    Thứ 6 tiết 4,5,6 (LT)';

    $string = trim('304A5 NCT GD KTX');

    // lấy địa điểm học
    $array = array();
    if (str_contains($string, "(1)")) {
        $list = explode("(1)", $string);
        $string = $list[1];
    }
    if (str_contains($string, "(1,2)")) {
        $list = explode("(1,2)", $string);
        $string = $list[1];
    }
    if (str_contains($string, "(2)")) {
        $list = explode("(2)", $string);
        array_push($array, $list[0]);
        $string = $list[1];
    }
    if (str_contains($string, "(2,3)")) {
        $list = explode("(2,3)", $string);
        array_push($array, $list[0]);
        $string = $list[1];
    }
    if (str_contains($string, "(3)")) {
        $list = explode("(3)", $string);
        array_push($array, $list[0]);
        $string = $list[1];
    }
    if (sizeof($array) == 0) {
        array_push($array, $string);
    } else {
        array_push($array, $list[1]);
    }


    // lấy thứ và tiết
    $listDay = array_filter(explode("Từ", trim($string1)));
    //var_dump($listDay);
    $index = 0;
    foreach ($listDay as $listd) {
        $time = explode(":", $listd);
        //tách lấy ngày bắt đầu và ngày kết thúc
        $day = $time[0];
        $startDay = date("Y-m-d", strtotime(str_replace('/', '-',trim(explode("đến", $day)[0]))));
        $endDay = date("Y-m-d", strtotime(str_replace('/', '-',trim(explode("đến", $day)[1]))));

        $listThu = explode("Thứ", $time[1]);
        if (sizeof($listThu) == 1) {
            var_dump($startDay . ' ' . $endDay . ' ' . 'null' . ' ' . 'null' . ' ' . 'null');
        } else {
            unset($listThu[0]);
            foreach ($listThu as $listt) {
                $listTiet = explode("tiết", $listt);
                $ca = '1';
                if (str_contains($listTiet[1], '1,2,3')) {
                    $ca = '1';
                } else if (str_contains($listTiet[1], '4,5,6')) {
                    $ca = '2';
                } else if (str_contains($listTiet[1], '7,8,9')) {
                    $ca = '3';
                } else if (str_contains($listTiet[1], '10,11,12')) {
                    $ca = '4';
                }
                var_dump($startDay . ' ' . $endDay . ' ' . trim($listTiet[0]) . ' ' . $ca . ' ' . $array[$index]);
            }
        }
        sizeof($array)-1 > $index ? $index++ : $index;
    }

    // foreach($listDate as $date) {
    //     if ($date != '') {
    //         $time = explode(":", $date);
    //         //tách lấy ngày bắt đầu và ngày kết thúc
    //         $day = $time[0];
    //         $startDay = date("Y-m-d", strtotime(str_replace('/', '-',explode("đến", $day)[0])));
    //         $endDay = date("Y-m-d", strtotime(str_replace('/', '-',explode("đến", $day)[1])));


    //         //tách lấy tiết học
    //         $lesson = explode("tiết", $time[1]);
    //         //nếu có tiết học thì lấy tiết học và ca
    //         if (sizeof($lesson) != 1) {
    //             $weekDay = trim($lesson[0])[strlen(trim($lesson[0]))-1];
    //             $ca = '1';
    //             if (str_contains($lesson[1], '1,2,3')) {
    //                 $ca = '1';
    //             } else if (str_contains($lesson[1], '4,5,6')) {
    //                 $ca = '2';
    //             } else if (str_contains($lesson[1], '7,8,9')) {
    //                 $ca = '3';
    //             } else if (str_contains($lesson[1], '10,11,12')) {
    //                 $ca = '4';
    //             }

    //         }
    //         //return $beginDay;
    //     }
    // }

?>
