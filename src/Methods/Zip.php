<?php

namespace RIterator\Methods;

use RIterator\Iterator;
use RIterator\IteratorMethod;

class Zip extends IteratorMethod {
    protected function __construct(Iterator $iterator, private Iterator $second) {
        parent::__construct($iterator);
    }

    public function next() {
        return [$this->iterator->next(), $this->second->next()];
    }
}
