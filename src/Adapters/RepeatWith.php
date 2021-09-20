<?php


namespace RIterator\Adapters;


use Closure;
use RIterator\Iterator;

class RepeatWith extends Iterator {
    public function __construct(private Closure $closure) {}

    public function size_hint() { return -1; }

    public function next() {
        return ($this->closure)();
    }
}