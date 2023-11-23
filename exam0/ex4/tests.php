<?php

require_once __DIR__ . '/../vendor/php-test-framework/public-api.php';
require_once __DIR__ . '/ex4.php';

function shouldReturnTheCorrectDevelopers() {

    $developers = getDevelopers();

    assertThat(count($developers), is(3));

    getDeveloperByName($developers, 'Alice');

    getDeveloperByName($developers, 'Bob');

    getDeveloperByName($developers, 'David');
}

function developersHaveCorrectTickets() {

    $developers = getDevelopers();

    $alice = getDeveloperByName($developers, 'Alice');
    assertThat($alice->tickets[0]->text, is('Ticket 1'));
    assertThat($alice->tickets[1]->text, is('Ticket 3'));
    assertThat($alice->tickets[2]->text, is('Ticket 4'));

    $bob = getDeveloperByName($developers, 'Bob');
    assertThat($bob->tickets[0]->text, is('Ticket 2'));

    $david = getDeveloperByName($developers, 'David');
    assertThat($david->tickets[0]->text, is('Ticket 5'));
}

function developersAreInCorrectOrder() {

    $developers = getDevelopers();
    print_r($developers);
    assertThat($developers[0]->name, is('David'));
    assertThat($developers[1]->name, is('Bob'));
    assertThat($developers[2]->name, is('Alice'));
}

#Helpers

function getDeveloperByName(array $developers, string $name): Developer {
    foreach ($developers as $developer) {
        if ($developer->name === $name) {
            return $developer;

        }
    }
    throw new RuntimeException('List does not contain developer with name ' . $name);
}

stf\runTests(new stf\PointsReporter([
    1 => 3,
    2 => 12,
    3 => 17]));
