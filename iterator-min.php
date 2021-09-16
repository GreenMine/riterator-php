<?php

abstract class RIterator {
    protected RIterator|null $iterator;

    protected function __construct(RIterator $iterator = null) {
        $this->iterator = $iterator;
    }

    public function next() {
        return $this->iterator->next();
    }

    public function size_hint() {
        return $this->iterator->size_hint();
    }

    //EDITOR FUNCTIONS
    public function map(Closure $closure) {
        return new RIteratorMap($this, $closure);
    }

    public function filter(Closure $closure) {
        return new RIteratorFilter($this, $closure);
    }

    public function take_while(Closure $closure) {
        return new RIteratorWhile($this, $closure);
    }

    public function take(int $n) {
        return new RIteratorTake($this, $n);
    }

    public function zip(RIterator $iterator) {
        return new RIteratorZip($this, $iterator);
    }

    public function chain(RIterator $iterator) {
        return new RIteratorChain($this, $iterator);
    }

    public function enumerate() {
        return new RIteratorEnumerate($this);
    }

    //EXECUTOR FUNCTIONS
    public function collect() {
        $result = array();
        try {
            while(true) $result[] = $this->next();
        } catch(EndException) {}

        return $result;
    }

    public function for_each(Closure $closure) {
        try {
            while(true) $closure($this->next());
        } catch(EndException) {}
    }

    public function sum() {
        $result = 0;
        try {
            while(true) $result += $this->next();
        } catch(EndException) {}

        return $result;
    }

    public function count() {
        $result = 0;
        try {
            while(true) {
                $this->next();
                $result++;
            }
        } catch (EndException) {}

        return $result;
    }

    public function any(Closure $closure) {
        try {
            while(true)
                if($closure($this->next()) === true)
                    return true;
        } catch(EndException) {}

        return false;
    }

    public function all(Closure $closure) {
        try {
            while(true)
                if($closure($this->next()) === false)
                    return false;
        } catch (EndException) {}
        return true;
    }

    public function join($delimiter = '') {
        $result = "";
        $is_first = true;
        try {
            while(true) {
                $value = $this->next();

                if($is_first) $is_first = false;
                else $result .= $delimiter;

                $result .= $value;
            }
        } catch (EndException) {}

        return $result;
    }

    public function nth(int $index) {
        try {
            //TODO: possible to optimize with skip functionality(if we doesn't have size-changing method in iterators)
            for($i = 0; $i < $index; $i++)
                $this->next();
            return $this->next();
        } catch(EndException) {}
        return null;
    }

    public function print($delimiter = PHP_EOL) {
        try {
            while(true)
                echo $this->next() . $delimiter;
        } catch(EndException) {}
    }
}

class FromArray extends RIterator {
    private int $array_len;
    private int $i = 0;

    public function __construct(private array $array) {
        $this->array_len = count($array);
        parent::__construct();
    }

    public function size_hint() {
        return $this->array_len;
    }

    public function next() {
        return $this->array[$this->i++] ?? throw new EndException();
    }
}

class FromRange extends RIterator {
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

class SplitString extends RIterator {
    private string $tok;
    public function __construct(
        string $string,
        public string $separator
    ) {
        $this->tok = strtok($string, $this->separator);
        parent::__construct();
    }

    public function next() {
        $current = $this->tok;

        if($current === "") throw new EndException();

        $this->tok = strtok($this->separator);
        return $current;
    }
}


class RIteratorMap extends RIterator {
    protected function __construct($iterator, private Closure $closure) {
        parent::__construct($iterator);
    }

    public function next() {
        return ($this->closure)($this->iterator->next());
    }
}

class RIteratorFilter extends RIterator {
    protected function __construct($iterator, private Closure $closure) {
        parent::__construct($iterator);
    }

    public function size_hint() { return -1; }

    public function next() {
        do {
            $value = $this->iterator->next();
        } while(!($this->closure)($value));

        return $value;
    }
}

class RIteratorWhile extends RIterator {
    protected function __construct($iterator, private Closure $closure) {
        parent::__construct($iterator);
    }

    public function size_hint() { return -1; }

    public function next() {
        $value = $this->iterator->next();

        return ($this->closure)($value) ? $value : throw new EndException();
    }
}

class RIteratorTake extends RIterator {
    protected function __construct(RIterator $iterator, private int $n) {
        parent::__construct($iterator);
    }

    public function next() {
        return $this->n-- > 0 ?
            $this->iterator->next() : throw new EndException();
    }
}

class RIteratorZip extends RIterator {
    protected function __construct(RIterator $iterator, private RIterator $second) {
        parent::__construct($iterator);
    }

    public function next() {
        return [$this->iterator->next(), $this->second->next()];
    }
}

class RIteratorChain extends RIterator {
    private RIterator|null $chained;

    protected function __construct(RIterator $iterator, RIterator $chained) {
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

class RIteratorEnumerate extends RIterator {
    private int $i = 0;

    public function next() {
        return [$this->i++, $this->iterator->next()];
    }
}

class EndException extends Exception {}
