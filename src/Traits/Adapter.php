<?php

namespace RIterator\Traits;


use RIterator\Adapters\FromArray;
use RIterator\Adapters\FromRange;
use RIterator\Adapters\SplitString;

trait Adapter {
    public static function from_array(array $array): FromArray {
        return new FromArray($array);
    }

    public static function range($start, $end, $step): FromRange {
        return new FromRange($start, $end, $step);
    }

    public static function split_str(string $str, string $separator) : SplitString {
        return new SplitString($str, $separator);
    }
}