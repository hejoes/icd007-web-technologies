<?php

function getDaysUnderTempDictionary(float $targetTemp): array {
    $inputFile = fopen(__DIR__ . '/data/temperatures-filtered.csv', "r");
    $result = array();
    $final_result = array();

    while (!feof($inputFile)) {
        $dict = fgetcsv($inputFile);
        if (!$dict || !is_numeric($dict[0])) {
            continue;
        }

        $year = $dict[0];
        $temp = $dict[4];


        if ($temp <= $targetTemp) {
            if (array_key_exists($year, $result)) {
                // If the key is already in the dictionary, increase the value by 1
                $result[$year]++;
            } else {
                // If the key is not in the dictionary, add it with a value of 1
                $result[$year] = 1;
            }

            foreach ($result as $value) {
                $final_result[$year] = round($value / 24, 2);
            }

        }
    }

    return $final_result;
}

//var_dump(getDaysUnderTempDictionary(-5));

function dictToString(array $dict): string {

    $result = "";
    foreach ($dict as $key => $value) {
        $result .= $key . " => " . $value . ", ";
    }

    $final = rtrim($result, ", ");
    // Eemaldab lõpust ,  osa

    return "[" . $final . "]";
}

//print dictToString(['a' => 1, 'b' => 2]);