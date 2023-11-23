<?php

    $messages = [
            'success' => 'Andmed salvestatud!',
            'error' => 'Viga salvestamisel!',
        ];

    $message_key = $_GET["message"] ?? null;
    $message = $messages[$message_key] ?? null;

    //var_dump($message);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Kinnitamise näide</title>
</head>
<body id="form-page">

<?php if ($message): ?>
<h3>
    <?= $message ?>
    <input type="hidden" id="message-success" name="button_name" value="button_value">
</h3>
<?php endif; ?>

<br>

<form method="post" action="confirm.php">
    <label for="ta">Andmed:</label>

    <input id="ta" name="data" />

    <button name="sendButton" type="submit">Salvesta</button>
</form>

</body>
</html>
