<?php

namespace RIterator;

use Closure;
use RIterator\Methods\Chain;
use RIterator\Methods\Enumerate;
use RIterator\Methods\Filter;
use RIterator\Methods\Flatten;
use RIterator\Methods\Map;
use RIterator\Methods\Take;
use RIterator\Methods\TakeWhile;
use RIterator\Methods\Zip;

abstract class Iterator {
    use Traits\Adapter;

    protected Iterator|null $iterator;

    protected function __construct(Iterator $iterator = null) {
        $this->iterator = $iterator;
    }

    /**
     * @return Iterator|mixed
     * @throws EndException
     */
    public abstract function next();

    public function size_hint() {
        return $this->iterator->size_hint();
    }

    //Produce iterator methods
    public function map(Closure $closure): Map {
        return new Map($this, $closure);
    }

    public function filter(Closure $closure): Filter {
        return new Filter($this, $closure);
    }

    public function take_while(Closure $closure): TakeWhile {
        return new TakeWhile($this, $closure);
    }

    public function take(int $n) : Take {
        return new Take($this, $n);
    }

    public function zip(Iterator $iterator): Zip {
        return new Zip($this, $iterator);
    }

    public function chain(Iterator $iterator): Chain {
        return new Chain($this, $iterator);
    }

    public function enumerate(): Enumerate {
        return new Enumerate($this);
    }

    public function flatten(): Flatten {
        return new Flatten($this);
    }

    //Consume iterator methods
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

    public function last() {
        $value = null;
        try {
            while(true) $value = $this->next();
        } catch(EndException) {}
        return $value;
    }

    public function print($delimiter = PHP_EOL): void {
        try {
            while(true)
                echo $this->next() . $delimiter;
        } catch(EndException) {}
    }
}