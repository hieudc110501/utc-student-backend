<?php



    $string = '(1)
    Học online 2 Phòng học online
    (2)
    [T3] 501-A7 Giảng đường A7
    [T5] 403-A7 Giảng đường A7
    (3)
    403-A7 Giảng đường A7';
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

    var_dump($array);

?>
