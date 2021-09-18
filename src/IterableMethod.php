<?php


namespace RIterator;


abstract class IterableMethod
{
    public function __construct(protected IterableMethod|null $iterator = null) {}

    public function size_hint() : int {
        return $this->iterator->size_hint();
    }

    abstract public function next();
}