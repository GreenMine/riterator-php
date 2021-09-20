<?php

namespace RIterator\Adapters;

use RIterator\DoubleEndedIterator;
use RIterator\EndException;
use RIterator\Iterator;

class FromRange extends DoubleEndedIterator {
    private int $current;

    public function __construct(
        private int $start,
        private int $end,
        private int $step = 1
    ) {
        $this->current = $start;
    }

    public function size_hint() {
        return (int)floor(($this->end - $this->start) / $this->step) + 1;
    }

    public function end() {
        //$this->start + floor(($this->end - $this->start) / $this->step) * $this->step
        $this->current = $this->start + ($this->size_hint() - 1) * $this->step;
    }

    public function next_back() {
        $current = $this->current;
        $this->current = $current - $this->step;

        return $current > $this->start ? $current : throw new EndException();
    }

    public function next() {
        $current = $this->current;
        $this->current = $current + $this->step;

        return $current < $this->end ? $current : throw new EndException();
    }
}
