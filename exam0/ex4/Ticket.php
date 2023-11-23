<?php

class Ticket {
    public string $id;
    public string $text;

    public function __construct($id, $text) {
        $this->id = $id;
        $this->text = $text;
    }

}

