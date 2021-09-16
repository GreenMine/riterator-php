<?php

namespace RIterator\Methods;

use RIterator\Iterator;
use RIterator\EndException;

class Take extends Iterator {
    protected function __construct(Iterator $iterator, private int $n) {
        parent::__construct($iterator);
    }

    public function next() {
        return $this->n-- > 0 ?
            $this->iterator->next() : throw new EndException();
    }
}
