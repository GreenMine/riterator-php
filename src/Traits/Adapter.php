<?php

namespace RIterator\Traits;


use Closure;
use Exception;
use RIterator\Adapters\AssociativeArray;
use RIterator\Adapters\Repeat;
use RIterator\Adapters\RepeatWith;
use RIterator\Adapters\SequentialArray;
use RIterator\Adapters\FromRange;
use RIterator\Adapters\SplitString;
use RIterator\Iterator;

trait Adapter {
    //Maybe create special class for array
    public static function from_array(array $array): Iterator {
        return self::is_assoc($array) ? new AssociativeArray($array) : new SequentialArray($array);
    }

    public static function range($start, $end, $step = 1): FromRange {
        return new FromRange($start, $end, $step);
    }

    public static function split_str(string $str, string $separator) : SplitString {
        return new SplitString($str, $separator);
    }

    public static function from(mixed $data) : Iterator {
        if($data instanceof Iterator) return $data;
        else if(is_array($data)) return self::from_array($data);

        throw new Exception('Type ' . gettype($data) . ' can\'t be converted to Iterator!');
    }

    public static function repeat($value) : Iterator {
        return new Repeat($value);
    }

    public static function repeat_with(Closure $closure) {
        return new RepeatWith($closure);
    }

    public static function chars(string $str) {
        return new SequentialArray($str);
    }

    private static function is_assoc(array $array) {
        if (empty($array)) return false;
        return array_keys($array) !== range(0, count($array) - 1);
    }
}