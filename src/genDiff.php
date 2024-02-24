<?php

namespace Differ\Differ;

use function Hexlet\Code\parser;
use function Hexlet\Code\plain;
use function Hexlet\Code\stylish;
use function Hexlet\Code\json;

const INDEX_FIRST_CHAR_KEY = 2;

function genDiff(string $filepath1, string $filepath2, string $format = 'stylish')
{
    $array1 = parser($filepath1);
    $array2 = parser($filepath2);

    if ($format === 'stylish') {
        $fn = fn($array) => stylish($array);
    } elseif ($format === 'plain') {
        $fn = fn($array) => plain($array);
    } elseif ($format === 'json') {
        $fn = fn($array) => json($array);
    }

    $genDiffArray = function (array|null $array1, array|null $array2, bool $prefix = false) use (&$genDiffArray) {
        if (is_null($array1) || is_null($array2)) {
            return null;
        }

        if ($array1 === [] && $array2 === []) {
            return [];
        }

        $equalKeys = array_intersect(array_keys($array1), array_keys($array2));

        $keysWithArray = array_filter($equalKeys, fn($key) => is_array($array1[$key]) && is_array($array2[$key]));
        $keysEqualValues = array_filter($equalKeys, fn($key) => $array1[$key] === $array2[$key]);

        $keysWithoutSign = array_merge($keysEqualValues, $keysWithArray);

        $filteredEqual =  array_filter($array1, fn($key) => in_array($key, $keysWithoutSign), ARRAY_FILTER_USE_KEY);
        $filtered1 =  array_filter($array1, fn($key) => !in_array($key, $keysWithoutSign), ARRAY_FILTER_USE_KEY);
        $filtered2 =  array_filter($array2, fn($key) => !in_array($key, $keysWithoutSign), ARRAY_FILTER_USE_KEY);

        $keysEqual = array_keys($filteredEqual);
        $arrayStringsEqual = array_reduce(
            $keysEqual,
            function ($acc, $key) use ($filteredEqual, $array1, $array2, $genDiffArray) {
                $newKey = "  {$key}";
                $acc[$newKey] =
                !is_array($filteredEqual[$key])
                    ? $filteredEqual[$key]
                    : $genDiffArray($array1[$key], $array2[$key]);
                return $acc;
            },
            []
        );
        $arrayStrings1 = array_reduce(
            array_keys($filtered1),
            function ($acc, $key) use ($filtered1, $array1, $prefix, $genDiffArray) {
                $newKey = (!$prefix) ? "- {$key}" : "  {$key}";
                $acc[$newKey] = !is_array($filtered1[$key]) ? $filtered1[$key] : $genDiffArray($array1[$key], [], true);
                return $acc;
            },
            []
        );
        $arrayStrings2 = array_reduce(
            array_keys($filtered2),
            function ($acc, $key) use ($filtered2, $array2, $prefix, $genDiffArray) {
                $newKey = (!$prefix) ? "+ {$key}" : "  {$key}";
                $acc[$newKey] = !is_array($filtered2[$key]) ? $filtered2[$key] : $genDiffArray([], $array2[$key], true);
                return $acc;
            },
            []
        );

        $result = array_merge($arrayStringsEqual, $arrayStrings1, $arrayStrings2);

        uksort($result, fn($a, $b) => substr($a, INDEX_FIRST_CHAR_KEY) <=> substr($b, INDEX_FIRST_CHAR_KEY));

        return $result;
    };
    //$isNullResult = is_null($genDiffArray($array1, $array2));
    //return $isNullResult ? null : $fn($genDiffArray($array1, $array2));
    return $fn($genDiffArray($array1, $array2));
}
