<?php

require_once 'Ticket.php';

class Developer {
    public string $id;
    public string $name;
    public array $tickets = [];

    public function __construct(string $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function addTicket(Ticket $ticket): void {
        $this->tickets[] = $ticket;
    }
}

