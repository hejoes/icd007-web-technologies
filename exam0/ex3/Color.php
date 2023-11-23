<?php

class Color {
    public string $id;
    public string $label;
    public string $className;

    public function __construct(string $id, string $label, string $className) {
        $this->id = $id;
        $this->label = $label;
        $this->className = $className;
    }

}

