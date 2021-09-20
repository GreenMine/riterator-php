<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\EndException;

class SplitString extends Iterator {
    private string $tok;
    public function __construct(
        string $string,
        public string $separator
    ) {
        $this->tok = strtok($string, $this->separator);
    }

    public function size_hint() {
        return -1;
    }

    public function next() {
        $current = $this->tok;

        if($current === "") throw new EndException();

        $this->tok = strtok($this->separator);
        return $current;
    }
}
