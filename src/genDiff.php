<?php

namespace Hexlet\Code;

use Hexlet\Code\readFile;

use function PHPUnit\Framework\isNull;

const INDEX_FIRST_CHAR_KEY = 4;

function toString(mixed $value): string
{
    // эта функция делает так, чтобы true и false выводились как строка
     return trim(var_export($value, true), "'");
}


function genDiff(string $file1, string $file2, string $nameDirWithFunction = 'src'): string|null
{
    $dataFile1 = readFile($file1, $nameDirWithFunction);
    $dataFile2 = readFile($file2, $nameDirWithFunction);

    if (is_null($dataFile1) || is_null($dataFile2)) {
        return null;
    }

    if ($dataFile1 === "" && $dataFile2 === "") {
        return "";
    }

    $jsonArray1 = json_decode($dataFile1, true) ?? [];
    $jsonArray2 = json_decode($dataFile2, true) ?? [];

    $jsonArray1 = array_map(fn($value) => toString($value), $jsonArray1);
    $jsonArray2 = array_map(fn($value) => toString($value), $jsonArray2);

    $equalKeys = array_intersect(array_keys($jsonArray1), array_keys($jsonArray2));

    $keysEqualValues = array_filter($equalKeys, fn($key) => $jsonArray1[$key] === $jsonArray2[$key]);

    $filteredEqual =  array_filter($jsonArray1, fn($key) => in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);
    $filteredJson1 =  array_filter($jsonArray1, fn($key) => !in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);
    $filteredJson2 =  array_filter($jsonArray2, fn($key) => !in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);

    $formedStr = function (string $sign, string $key, mixed $value): string {
        $parts = [' ', $sign, $key, ':', $value];
        return implode(' ', $parts);
    };

    $arrayStringsEqual = array_map(fn($key) => $formedStr(' ', $key, $filteredEqual[$key]), array_keys($filteredEqual));
    $arrayStrings1 = array_map(fn($key) => $formedStr('-', $key, $filteredJson1[$key]), array_keys($filteredJson1));
    $arrayStrings2 = array_map(fn($key) => $formedStr('+', $key, $filteredJson2[$key]), array_keys($filteredJson2));

    $result = array_merge($arrayStringsEqual, $arrayStrings1, $arrayStrings2);

    usort($result, fn($a, $b) => $a[INDEX_FIRST_CHAR_KEY] <=> $b[INDEX_FIRST_CHAR_KEY]);

    $parts = ["{", ...$result, "}\n"];
    $stringFromArray = implode("\n", $parts);

    return $stringFromArray;
}
