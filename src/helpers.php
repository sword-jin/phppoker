<?php

/**
 * Map function.
 *
 * @param array   $items
 * @param closure $fn
 */
if (! function_exists('map')) {
    function map($items, $fn) {
        $results = [];

        foreach ($items as $item) {
            $results[] = $fn($item);
        }

        return $results;
    }
}

/**
 * GroupBy function.
 *
 * @param array $arr
 */
if (! function_exists('groupBy')) {
    function groupBy(array $arr) {
        $results = [];
        rsort($arr);

        foreach ($arr as $value) {
            $results[$value] = isset($results[$value]) ? $results[$value] + 1 : 1;
        }
        uksort($results, function($a, $b) use ($results) {
            if ($results[$a] == $results[$b]) {
                return $a < $b ? 1 : -1;
            }
            return $results[$a] < $results[$b] ? 1 : -1;
        });

        return [array_keys($results), array_values($results), $arr];
    }
}
