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

    $formedStr = function (string $sign, string $key): string {
        $parts = [' ', $sign, $key];
        return implode(' ', $parts);
    };

    $arrayStringsEqual = array_reduce(array_keys($filteredEqual), function ($acc, $key) use ($filteredEqual) {
        $newKey = "  {$key}";
        $acc[$newKey] = $filteredEqual[$key];
        return $acc;
    }, []);
    $arrayStrings1 = array_reduce(array_keys($filtered1), function ($acc, $key) use ($filtered1) {
        $newKey = "- {$key}";
        $acc[$newKey] = $filtered1[$key];
        return $acc;
    }, []);
    $arrayStrings2 = array_reduce(array_keys($filtered2), function ($acc, $key) use ($filtered2) {
        $newKey = "+ {$key}";
        $acc[$newKey] = $filtered2[$key];
        return $acc;
    }, []);


    //$arrayStrings1 = array_map(fn($key) => $formedStr('-', $key, $filtered1[$key]), array_keys($filtered1));
    //$arrayStrings2 = array_map(fn($key) => $formedStr('+', $key, $filtered2[$key]), array_keys($filtered2));

    $result = array_merge($arrayStringsEqual, $arrayStrings1, $arrayStrings2);

    usort($result, fn(arrays_key($a), array_keys($b)) => $a <=> $b);

    var_dump($result);

    $parts = ["{", ...$result, "}\n"];
    $stringFromArray = implode("\n", $parts);

    return $stringFromArray;
}

$array1 = [
    'host' => "hexlet.io",
    'timeout' => 50,
    'proxy' => "123.234.53.22",
    'follow' => false
];

$array2 = [
    'timeout' => 20,
    'verbose' => true,
    'host' => "hexlet.io"
];

genDiff($array1, $array2);
