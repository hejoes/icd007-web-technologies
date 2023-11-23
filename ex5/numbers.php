<?php

require_once 'connection.php';

$conn = getConnection();

//$stmt = $conn->prepare('insert into number (num) values(:num)');
//
//foreach (range(1,100) as $num) {
//    $num = rand(1, 100);
//    $stmt->bindValue(":num", $num);
//    $stmt->execute();
//}


//$stmt = $conn->prepare('select * from number where num > :threshold');
//$stmt->bindValue(":threshold", 80);
//$stmt->execute();
//
//foreach ($stmt as $row) {
//    var_dump($row["num"]);
//    exit();
//}

//Kood, mis sisestab kontakti kooos kolme telefoni numbriga
$stmt = $conn->prepare('insert into contact (name) Values (:name);');
$stmt->bindValue(":name", 'Jill');
$stmt->execute();

$lastInsertId = $conn->lastInsertId();
$phones = ["12", "13", "14"];

foreach ($phones as $phone) {
    $stmt = $conn->prepare('insert into phone Values (:contact_id, :number);');
    $stmt->bindValue(":contact_id", $lastInsertId);
    $stmt->bindValue(":number", $phone);
    $stmt->execute();
}

var_dump($lastInsertId);
