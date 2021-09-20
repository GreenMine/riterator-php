<?php

namespace RIterator;

abstract class IteratorMethod extends Iterator {
    //TODO: maybe in param must be provide only IteratorMethod
    protected function __construct(protected Iterator $iterator) {}

    public function size_hint() {
        return $this->iterator->size_hint();
    }

    public abstract function next();
}