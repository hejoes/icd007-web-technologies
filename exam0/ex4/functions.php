<?php

function getConnectionWithData($dataFile): PDO {
    $conn = new PDO('sqlite::memory:');
    $statements = explode(';', file_get_contents($dataFile));

    foreach ($statements as $statement) {
        $conn->prepare($statement)->execute();
    }

    return $conn;
}

