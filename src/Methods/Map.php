<?php

namespace RIterator\Methods;

use RIterator\IterableMethod;
use Closure;

class Map extends IterableMethod {
    public function __construct($iterator, private Closure $closure) {
        parent::__construct($iterator);
    }

    public function next() {
        return ($this->closure)($this->iterator->next());
    }
}
