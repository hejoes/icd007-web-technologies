<?php

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/Developer.php';
require_once __DIR__ . '/Ticket.php';

function getDevelopers(): array {
    $conn = getConnectionWithData(__DIR__ . '/data.sql');
    $stmt = $conn->prepare('SELECT d.id as dev_id, d.name, t.id as ticket_id, t.text 
                              FROM developer as d
                              left join ticket as t on d.id = t.developer_id
                              WHERE t.id IS NOT NULL
                              ORDER BY d.name desc, t.id');
    $stmt->execute();

    $developers = [];
    /*foreach ($stmt as $developer) {
        $dev_id = $developer['dev_id'];
        $dev_name = $developer['name'];
        $ticket_id = $developer['ticket_id'];
        $text = $developer['text'];

        if (isset($developers[$dev_name]) and $ticket_id !== null) {   # check whether an element with the key $id exists in the $people array
            $person = $developers[$dev_name]; # muutuja person object antud id'ga

        } else {
            if ($ticket_id !== null) {
                $person = new Developer($dev_id, $dev_name); # Create new person
                $developers[$dev_name] = $person;
            }
        }
        if ($ticket_id !== null) {
            $person->addTicket(new Ticket($ticket_id, $text));
        }

    }*/
    foreach ($stmt as $developer) {
        $dev_id = $developer['dev_id'];
        $dev_name = $developer['name'];
        $tick_id = $developer['ticket_id'];
        $text = $developer['text'];

        if (!isset($developers[$dev_name])) { //Kui key ei ole listis siis lisame ta listi
            $person = new Developer($dev_id, $dev_name);
            $developers[$dev_name] = $person;
            $person->addTicket(new Ticket($tick_id, $text));

        } else {
            $person = $developers[$dev_name];
            $person->addTicket(new Ticket($tick_id, $text));
        }
    }

    return $developers;
}


