<?php

namespace Hexlet\Code;

const INDEX_FIRST_CHAR_KEY = 4;

function toString(mixed $value): string
{
    // эта функция делает так, чтобы true и false выводились как строка
     return trim(var_export($value, true), "'");
}

function genDiff(array|null $array1, array|null $array2): string|null
{
    if (is_null($array1) || is_null($array2)) {
        return null;
    }

    if ($array1 === [] && $array2 === []) {
        return "";
    }

    $array1 = array_map(fn($value) => toString($value), $array1);
    $array2 = array_map(fn($value) => toString($value), $array2);

    $equalKeys = array_intersect(array_keys($array1), array_keys($array2));

    $keysEqualValues = array_filter($equalKeys, fn($key) => $array1[$key] === $array2[$key]);

    $filteredEqual =  array_filter($array1, fn($key) => in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);
    $filtered1 =  array_filter($array1, fn($key) => !in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);
    $filtered2 =  array_filter($array2, fn($key) => !in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);

    $formedStr = function (string $sign, string $key, mixed $value): string {
        $parts = [' ', $sign, $key, ':', $value];
        return implode(' ', $parts);
    };

    $arrayStringsEqual = array_map(fn($key) => $formedStr(' ', $key, $filteredEqual[$key]), array_keys($filteredEqual));
    $arrayStrings1 = array_map(fn($key) => $formedStr('-', $key, $filtered1[$key]), array_keys($filtered1));
    $arrayStrings2 = array_map(fn($key) => $formedStr('+', $key, $filtered2[$key]), array_keys($filtered2));

    $result = array_merge($arrayStringsEqual, $arrayStrings1, $arrayStrings2);

    usort($result, fn($a, $b) => $a[INDEX_FIRST_CHAR_KEY] <=> $b[INDEX_FIRST_CHAR_KEY]);

    $parts = ["{", ...$result, "}\n"];
    $stringFromArray = implode("\n", $parts);

    return $stringFromArray;
}
