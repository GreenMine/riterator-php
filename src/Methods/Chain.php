<?php

namespace RIterator\Methods;

use RIterator\EndException;
use RIterator\Iterator;
use RIterator\IteratorMethod;

class Chain extends IteratorMethod {
    private Iterator|null $chained;

    protected function __construct(Iterator $iterator, Iterator $chained) {
        $this->chained = $chained;
        parent::__construct($iterator);
    }

    public function next() {
        try {
            return $this->iterator->next();
        } catch(EndException) {
            if($this->chained != null) {
                $this->iterator = $this->chained;
                $this->chained = null;

                return $this->iterator->next();
            }
        }
        throw new EndException();
    }
}
