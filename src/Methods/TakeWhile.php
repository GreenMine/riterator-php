<?php


namespace RIterator\Methods;


use RIterator\Iterator;
use RIterator\EndException;
use Closure;
use RIterator\IteratorMethod;

class TakeWhile extends IteratorMethod {
    protected function __construct($iterator, private Closure $closure) {
        parent::__construct($iterator);
    }

    public function size_hint() { return -1; }

    public function next() {
        $value = $this->iterator->next();

        return ($this->closure)($value) ? $value : throw new EndException();
    }
}
