<?php

ini_set('display_errors', '1');

require_once '../ex1/ex7.php';
require_once '../ex2/functions.php';

var_dump($_POST);

$command = $_POST['command'] ?? 'show-form';
$page = $_GET["page"] ?? "";

if ($command === 'show-form' && $page === "avg-winter-temp") {
    include 'pages/avg-winter-temp.php';
}
else if ($command === 'show-form') {

    include 'pages/days-under-temp.php';

} else if ($command === 'days-under-temp') {
    $year = intval($_POST["year"]);
    $temp = floatval($_POST["temp"]);
    $result = getDaysUnderTemp($year, $temp);
    $message = $result;

    include 'pages/result.php';

} else if ($command === "avg-winter-temp") {
    $year = intval($_POST["year"]);
    $result = getAverageWinterTemp($year);
    $message = $result;

    include 'pages/result.php';
}

else {
    throw new Error('unknown command: ' . $command);
}

