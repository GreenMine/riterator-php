<?php


namespace RIterator\Methods;


use RIterator\Iterator;
use RIterator\EndException;
use Closure;

class IteratorWhile extends Iterator {
    protected function __construct($iterator, private Closure $closure) {
        parent::__construct($iterator);
    }

    public function next() {
        $value = $this->iterator->next();

        return ($this->closure)($value) ? $value : throw new EndException();
    }
}
