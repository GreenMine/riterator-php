<?php

namespace RIterator\Methods;

use RIterator\EndException;
use RIterator\Iterator;

class IteratorChain extends Iterator {
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
