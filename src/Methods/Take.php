<?php

namespace RIterator\Methods;

use RIterator\Iterator;
use RIterator\EndException;
use RIterator\IteratorMethod;

class Take extends IteratorMethod {
    protected function __construct(Iterator $iterator, private int $n) {
        parent::__construct($iterator);
    }

    public function size_hint() {
        return $this->n;
    }

    public function next() {
        return $this->n-- > 0 ?
            $this->iterator->next() : throw new EndException();
    }
}
