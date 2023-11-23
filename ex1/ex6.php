<?php

$inputFile = fopen("data/temperatures-sample.csv", "r");
$outputFile = fopen("temperatures-filtered.csv", "w");

while(! feof($inputFile)) {
    //Niikaua kui fail lppenud pole, niikaua loopime
    $dict = fgetcsv($inputFile);

    if (!$dict || !is_numeric($dict[0])) {
        continue;
    }
    //kasutame spliti, võtame teise osa ära ja teisendame numbriks tund (veerg 3 ) puhul

    $year = intval($dict[0]);
    $month = $dict[1];
    $day = $dict[2];
    $hour = $dict[3];
    $newhour = explode(":", $hour);
    $temp = $dict[8];

    if ($year == 2004 || $year == 2021) {
        fputcsv($outputFile, [$year, $month, $day, $newhour[0], $temp]);
    }
}

fclose($inputFile);
fclose($outputFile);

