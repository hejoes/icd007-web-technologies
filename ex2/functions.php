<?php

function getAverageWinterTemp(int $targetYear): float {


    $inputFile = fopen("../ex1/data/temperatures-filtered.csv", "r");
    $tempsum = 0;
    $count = 0;

    while (!feof($inputFile)) {
        $dict = fgetcsv($inputFile);

        if (! $dict || !is_numeric($dict[0])) {     // Selleks et kogu pikem kood ei läheks siia ifi sisse
            continue;
        }
        $year = intval($dict[0]);
        $month = $dict[1];
        $temp = $dict[4];

        if ($year == $targetYear) {
            if ($month == 12 || $month == 1 || $month == 2) {
                $tempsum += $temp;
                $count += 1;
            }
        }
    }

    return round(($tempsum / $count), 2 );
}

//getAverageWinterTemp(2021);