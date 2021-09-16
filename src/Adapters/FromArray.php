<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\DoubleEndedIterator;
use RIterator\EndException;

class FromArray extends DoubleEndedIterator {
    private int $array_len;
    private int $i = 0;

    public function __construct(private array $array) {
        $this->array_len = count($array);
        parent::__construct();
    }

    public function size_hint() {
        return $this->array_len;
    }

    public function next_back() {
        return $this->array[$this->i--] ?? throw new EndException();
    }

    public function end() {
        $this->i = $this->array_len - 1;
    }

    public function next() {
        return $this->array[$this->i++] ?? throw new EndException();
    }
}
