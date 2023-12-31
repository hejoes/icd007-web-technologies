<?php

namespace tplLib\node;

abstract class AbstractNode {

    protected ?string $name;

    protected array $children = [];

    public function __construct(?string $name) {
        $this->name = $name;
    }

    public abstract function render($scope);

    public function getTagName() : ?string {
        return $this->name;
    }

    public function getChildren() : array {
        return $this->children;
    }

    public function addChild($child) : void {
        $this->children[] = $child;
    }

    public function addChildren($children) : void {
        $this->children = array_merge($this->children, $children);
    }

    public function removeChild($child) {
        $predicate = function ($each) use ($child) {
            return $each !== $child;
        };

        $this->children = array_values(array_filter($this->children, $predicate));
    }

    public function insertBefore($new_node, $old_node) {
        $tmp = [];
        foreach ($this->children as $current) {
            if ($current === $old_node) {
                $tmp[] = $new_node;
            }

            $tmp[] = $current;
        }

        $this->children = $tmp;
    }
}
