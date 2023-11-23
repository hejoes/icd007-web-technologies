<?php

function getDaysUnderTemp(int $targetYear, float $targetTemp): float {
    $inputFile = fopen(__DIR__ . "/data/temperatures-filtered.csv", "r");
    $hourSum = 0;

    while (!feof($inputFile)) {
        $dict = fgetcsv($inputFile);

        if (! $dict || !is_numeric($dict[0])) {
            continue;
        }

        $year = intval($dict[0]);
        $temp = $dict[4];

        if ($year == $targetYear && $temp <= $targetTemp) {
            $hourSum++;
        }
    }

    return round($hourSum / 24, 2);
}
?>

