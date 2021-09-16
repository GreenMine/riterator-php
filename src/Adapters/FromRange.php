<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\EndException;

class FromRange extends Iterator {
    private int $current;

    public function __construct(
        int $start,
        private int $end,
        private int $step = 1
    ) {
        $this->current = $start;
        parent::__construct();
    }

    public function size_hint() {
        return floor(($this->end - $this->current) / $this->step) + 1;
    }

    public function next() {
        $current = $this->current;
        $this->current = $current + $this->step;

        return $current < $this->end ? $current : throw new EndException();
    }
}
