<?php


namespace RIterator\Methods;

use RIterator\IterableMethod;

class Enumerate extends IterableMethod {
    private int $i = 0;

    public function next() {
        return [$this->i++, $this->iterator->next()];
    }
}
