<?php

$list = [3, 2, 6];
function listToString(array $list): string {
    $result = '[' . join(', ', $list) . ']';
    return $result;
}

//print listToString($list);
//print gettype($list);




