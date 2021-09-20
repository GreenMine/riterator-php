<?php

namespace RIterator\Methods;

use Exception;
use RIterator\EndException;
use RIterator\Iterator;
use RIterator\IteratorMethod;

class Flatten extends IteratorMethod {
    private Iterator $current;

    protected function __construct(Iterator $iterator)
    {
        parent::__construct($iterator);
        //TODO: think about it
        $this->update();
    }

    public function next() {
        try {
            return $this->current->next();
        } catch(EndException) {}

        $this->update();
        return $this->current->next();
    }

    private function update() {
        $this->current = Iterator::from($this->iterator->next());
    }
}