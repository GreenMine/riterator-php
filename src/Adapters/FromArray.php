<?php

namespace RIterator\Adapters;

use Countable;
use RIterator\Iterator;
use RIterator\DoubleEndedIterator;
use RIterator\EndException;

class FromArray extends DoubleEndedIterator {
    private int $data_len;
    private int $i = 0;

    public function __construct(private Countable|string|array $data) {
        $this->data_len = is_string($data) ? strlen($data) : count($data);
        parent::__construct();
    }

    public function size_hint() {
        return $this->data_len;
    }

    public function end() {
        $this->i = $this->data_len - 1;
    }

    public function next_back() {
        return $this->data[$this->i--] ?? throw new EndException();
    }

    public function next() {
        return $this->data[$this->i++] ?? throw new EndException();
    }
}
