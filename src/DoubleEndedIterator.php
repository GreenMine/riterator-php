<?php

namespace RIterator;

//use RIterator\Methods\Reverse;

/*abstract class DoubleEndedIterator extends Iterator {
    public function __construct(DoubleEndedIterator $iterator = null) {
        parent::__construct($iterator);
    }

    public abstract function next_back();

    public function end() {
        exit('Not implemented method end()');
    }

    public function last() {
        $this->end();
        return $this->next_back();
    }

    public function rev() : Reverse {
        return new Reverse($this);
    }
}*/