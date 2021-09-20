<?php


namespace RIterator\Methods;

use Closure;
use RIterator\IteratorMethod;

class Filter extends IteratorMethod {
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
