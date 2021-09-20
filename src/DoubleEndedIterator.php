<?php

namespace RIterator;

use RIterator\Methods\Reverse;

abstract class DoubleEndedIterator extends IteratorMethod {

    public abstract function next_back();
    abstract public function end();

    public function last(): mixed {
        $this->end();
        return $this->next_back();
    }

    public function rev() : Reverse {
        return new Reverse($this);
    }
}
