<?php

namespace RIterator\Methods;

use RIterator\Iterator;

class IteratorZip extends Iterator {
    protected function __construct(Iterator $iterator, private Iterator $second) {
        parent::__construct($iterator);
    }

    public function next() {
        return [$this->iterator->next(), $this->second->next()];
    }
}
