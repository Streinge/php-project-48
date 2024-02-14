<?php

namespace Hexlet\Code;

const INDEX_FIRST_CHAR_KEY = 4;

function toString(mixed $value): string
{
    // эта функция делает так, чтобы true и false выводились как строка
     return trim(var_export($value, true), "'");
}


function genDiff(string $file1, string $file2): string
{
    $absolutPath = function (string $file): string {
        $directoryProject = substr(__DIR__, 0, -3);
        $arrayPathFile = explode('/', $file);
        return "{$directoryProject}tests/fixtures/{$arrayPathFile[count($arrayPathFile) - 1]}";
    };
 
    $isEmpty1 = empty(file_get_contents($absolutPath($file1)));
    $isEmpty2 = empty(file_get_contents($absolutPath($file2)));

    if ($isEmpty1 && $isEmpty2) {
        return '';
    }

    $jsonArray1 = json_decode(file_get_contents($absolutPath($file1)), true) ?? [];
    $jsonArray2 = json_decode(file_get_contents($absolutPath($file2)), true) ?? [];

    $jsonArray1 = array_map(fn($value) => toString($value), $jsonArray1);
    $jsonArray2 = array_map(fn($value) => toString($value), $jsonArray2);

    $equalKeys = array_intersect(array_keys($jsonArray1), array_keys($jsonArray2));

    $keysEqualValues = array_filter($equalKeys, fn($key) => $jsonArray1[$key] === $jsonArray2[$key]);

    $filteredEqual =  array_filter($jsonArray1, fn($key) => in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);
    $filteredJson1 =  array_filter($jsonArray1, fn($key) => !in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);
    $filteredJson2 =  array_filter($jsonArray2, fn($key) => !in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);

    $formedStr = function (string $sign, string $key, mixed $value): string {
        return "  {$sign} {$key} : {$value}";
    };

    $arrayStringsEqual = array_map(fn($key) => $formedStr(' ', $key, $filteredEqual[$key]), array_keys($filteredEqual));
    $arrayStrings1 = array_map(fn($key) => $formedStr('-', $key, $filteredJson1[$key]), array_keys($filteredJson1));
    $arrayStrings2 = array_map(fn($key) => $formedStr('+', $key, $filteredJson2[$key]), array_keys($filteredJson2));

    $result = array_merge($arrayStringsEqual, $arrayStrings1, $arrayStrings2);

    usort($result, fn($a, $b) => $a[INDEX_FIRST_CHAR_KEY] <=> $b[INDEX_FIRST_CHAR_KEY]);

    $stringFromArray = implode("\n", $result);

    return "{\n{$stringFromArray}\n}\n";
}
