<?php


namespace RIterator\Methods;

use RIterator\Iterator;
use Closure;

class IteratorFilter extends Iterator {
    protected function __construct($iterator, private Closure $closure) {
        parent::__construct($iterator);
    }

    public function size_hint() { return -1; }

    public function next() {
        do {
            $value = $this->iterator->next();
        } while(!($this->closure)($value));

        return $value;
    }
}
