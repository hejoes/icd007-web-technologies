<?php

require_once 'Color.php';

const ERROR_MESSAGE = 'Tingimuste kinnitamine on kohustuslik!';
$selectedColor = ($_POST['color']);

$colors = [
    'red' => new Color('red', 'Punane', 'my-red'),
    'green' => new Color('green', 'Roheline', 'my-green'),
    'blue' => new Color('blue', 'Sinine', 'my-blue')
];
$color = $_GET['color'];
if (isset($_POST['cmd'])) {
    if ($_POST['cmd'] === 'select' && array_key_exists($selectedColor, $colors)){
        $color = $selectedColor;
        $subTemplatePath = 'confirm.php'; // sub-template selection
        include('main.php'); // include the main template to display the sub-template
    }
    else if ($_POST['cmd'] === 'forward' and $_POST['conditions'] === strval(1) and isset($_POST['color'])) {
        // KUi tahame conditionsitest edasi minna, kontrollime ka et conditions nuppu oleks vajutatud
        $color = $colors[$selectedColor];
        var_dump($color);
        // Add the redirect header
        header('Location: final.php?color=' . ($color->className));

        $className = $color;
        exit(); // Terminate the script execution after redirect


    } else {
        $subTemplatePath = 'confirm.php'; // sub-template selection
        $errorMessage = ERROR_MESSAGE; // define the error message
        include('main.php'); // include the main template to display the sub-template
    } }

else {
    $subTemplatePath = 'form.php'; // sub-template selection
    include('main.php'); // include the main template to display the sub-template
}







