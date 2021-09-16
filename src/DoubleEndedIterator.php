<?php

namespace RIterator;

use RIterator\Methods\Reverse;

abstract class DoubleEndedIterator extends Iterator {
    public function __construct(DoubleEndedIterator $iterator = null) {
        parent::__construct($iterator);
    }

    public abstract function next_back();

    public function end() {
        exit('unreachable: need to think about it');
    }

    public function rev() : Reverse {
        return new Reverse($this);
    }
}
