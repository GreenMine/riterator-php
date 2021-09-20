<?php


namespace RIterator\Methods;

use RIterator\IteratorMethod;

class Enumerate extends IteratorMethod {
    private int $i = 0;

    public function next() {
        return [$this->i++, $this->iterator->next()];
    }
}
