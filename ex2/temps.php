<?php
require_once '../ex1/ex8.php';

require_once 'functions.php';


//ilma seda funktsiooni lisamata annab 2string errori
function getDaysUnderTemp(int $targetYear, float $targetTemp): float {
    $inputFile = fopen( "../ex1/data/temperatures-filtered.csv", "r");
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


$opts = getopt('c:y:t:', ['command:', 'year:', 'temp:']);

$command = $opts['command'] ?? null;
//kontrollib kas commandil on väärtus olemas, kui ei ole siis paneb null

$c_year = $opts['year'] ?? null;
$c_temp = $opts['temp'] ?? null;

$message = "command is missing or is unknown";
if ($command === 'days-under-temp') {

    if ($c_year !== null && $c_temp !== null) {

        print(getDaysUnderTemp(intval($c_year), intval($c_temp)));
    } else {
        showError($message);
    }

} else if ($command === 'days-under-temp-dict') {
    if ($c_temp != null) {

        $dict = (getDaysUnderTempDictionary(intval($c_temp)));
        $result = '';

        foreach ($dict as $key => $value) {
            $result .= $key . " => " . $value . ", ";
        }

        $final = rtrim($result, ", ");
        // Eemaldab lõpust ,  osa

        print "[" . $final . "]";

    } else {
        showError($message);
    }
} else if ($command === 'avg-winter-temp') {
    if ($c_year != null) {
        print (getAverageWinterTemp($c_year));
    }

} else {
    showError($message);
}

function showError(string $message): void {
    fwrite(STDERR, $message . PHP_EOL);
    exit(1);
}

