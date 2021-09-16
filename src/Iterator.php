<?php

namespace RIterator;

use Closure;
use Exception;
use JetBrains\PhpStorm\Pure;
use RIterator\Methods\IteratorChain;
use RIterator\Methods\IteratorEnumerate;
use RIterator\Methods\IteratorFilter;
use RIterator\Methods\IteratorMap;
use RIterator\Methods\IteratorTake;
use RIterator\Methods\IteratorWhile;
use RIterator\Methods\IteratorZip;

abstract class Iterator {
    protected Iterator|null $iterator;

    protected function __construct(Iterator $iterator = null) {
        $this->iterator = $iterator;
    }

    /**
     * @return Iterator|mixed
     * @throws EndException
     */
    public function next() {
        return $this->iterator->next();
    }

    public function size_hint() {
        return $this->iterator->size_hint();
    }

    //EDITOR FUNCTIONS
    public function map(Closure $closure): IteratorMap {
        return new IteratorMap($this, $closure);
    }

    public function filter(Closure $closure): IteratorFilter {
        return new IteratorFilter($this, $closure);
    }

    public function take_while(Closure $closure): IteratorWhile {
        return new IteratorWhile($this, $closure);
    }

    public function take(int $n) : IteratorTake {
        return new IteratorTake($this, $n);
    }

    public function zip(Iterator $iterator): IteratorZip {
        return new IteratorZip($this, $iterator);
    }

    public function chain(Iterator $iterator): IteratorChain {
        return new IteratorChain($this, $iterator);
    }

    public function enumerate(): IteratorEnumerate {
        return new IteratorEnumerate($this);
    }

    //EXECUTOR FUNCTIONS
    public function collect(): array {
        $result = array();
        try {
            while(true) $result[] = $this->next();
        } catch(EndException) {}

        return $result;
    }

    public function for_each(Closure $closure): void {
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

    public function count(): int {
        $result = 0;
        try {
            while(true) {
                $this->next();
                $result++;
            }
        } catch (EndException) {}

        return $result;
    }

    public function any(Closure $closure): bool {
        try {
            while(true)
                if($closure($this->next()) === true)
                    return true;
        } catch(EndException) {}

        return false;
    }

    public function all(Closure $closure): bool {
        try {
            while(true)
                if($closure($this->next()) === false)
                    return false;
        } catch (EndException) {}
        return true;
    }

    public function join($delimiter = ''): string {
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

    public function print($delimiter = PHP_EOL): void {
        try {
            while(true)
                echo $this->next() . $delimiter;
        } catch(EndException) {}
    }
}

class EndException extends Exception {}
