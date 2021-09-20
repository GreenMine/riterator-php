<?php


namespace RIterator\Adapters;


use RIterator\Iterator;

class Repeat extends Iterator {
    public function __construct(private mixed $value) {}

    public function size_hint() {
        return -1;
    }

    public function next() {
        return $this->value;
    }
}