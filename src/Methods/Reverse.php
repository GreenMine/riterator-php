<?php


namespace RIterator\Methods;


use RIterator\DoubleEndedIterator;

class Reverse extends DoubleEndedIterator {
    public function __construct(DoubleEndedIterator $iterator) {
        $iterator->end();
        parent::__construct($iterator);
    }

    public function next_back() {
        return $this->iterator->next();
    }

    public function next() {
        return $this->iterator->next_back();
    }
}
