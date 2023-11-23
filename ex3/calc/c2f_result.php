<?php
require_once 'functions.php';

$input = $_POST["temperature"] ?? null;
if ($input === null || $input === "") {
    $message = "Insert temperature";
} elseif (!is_numeric($input)) {
    $message = "Temperature must be an integer";
} else {
    $value = floatval($_POST["temperature"]);
    $result = c2f($value);
    $message = sprintf("%d degrees in Celsius is %d degrees in Fahrenheit.", $value, $result);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Celsius to Fahrenheit</title>
</head>
<body>

    <nav>
        <a href="index.html">Celsius to Fahrenheit</a> |
        <a href="f2c.html">Fahrenheit to Celsius</a>
    </nav>

    <main>

        <h3>Celsius to Fahrenheit</h3>
        <em><?php print $message ?></em>


    </main>

</body>
</html>
