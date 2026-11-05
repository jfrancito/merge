<?php

if (!function_exists('_count')) {
    function _count($val): int {
        if ($val === null) return 0;
        if (is_array($val) || $val instanceof \Countable) return \count($val);
        if (is_object($val)) return 1;
        return empty($val) ? 0 : 1;
    }
}
