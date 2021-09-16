<?php

namespace RIterator\Methods;

use RIterator\Iterator;
use Closure;

class Map extends Iterator {
    protected function __construct($iterator, private Closure $closure) {
        parent::__construct($iterator);
    }

    public function next() {
        return ($this->closure)($this->iterator->next());
    }
}
