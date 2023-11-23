<?php

$input = '[1, 4, 2, 0]';

function stringToIntegerList(string $input): array {
    $input = str_replace("[", "", $input);
    $input = str_replace("]", "", $input);

    $list = explode(",", $input);

    $result = [];
    foreach ($list as $each) {
        $result[] = intval($each);
    }

    return $result;
}

// check that the restored list is the same as the input list.
// var_dump($list === [1, 4, 2, 0]); // should print "bool(true)"

//var_dump(stringToIntegerList($input));
