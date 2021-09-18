<?php


namespace RIterator\Methods;

use RIterator\IterableMethod;
use Closure;

class Filter extends IterableMethod {
    public function __construct($iterator, private Closure $closure) {
        parent::__construct($iterator);
    }

    public function size_hint(): int { return -1; }

    public function next() {
        do {
            $value = $this->iterator->next();
        } while(!($this->closure)($value));

        return $value;
    }
}
