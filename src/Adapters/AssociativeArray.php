<?php

namespace RIterator\Adapters;

use Generator;
use RIterator\EndException;
use RIterator\Iterator;

class AssociativeArray extends Iterator {
    private int $data_len;
    private Generator $gen;

    public function __construct(array $data) {
        $this->gen = self::array_to_gen($data);
        $this->data_len = count($data);

        parent::__construct();
    }

    public function size_hint() {
        return $this->data_len;
    }

    public function next() {
        $current = $this->gen->current();
        if($current === null) throw new EndException();

        $this->gen->next();

        return $current;
    }

    private function array_to_gen(array $array) : Generator {
        foreach($array as $k => $v)
            yield [$k, $v];
    }
}
