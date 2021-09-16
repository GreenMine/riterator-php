<?php


namespace RIterator\Methods;

use RIterator\Iterator;

class IteratorEnumerate extends Iterator {
    private int $i = 0;

    public function next() {
        return [$this->i++, $this->iterator->next()];
    }
}
