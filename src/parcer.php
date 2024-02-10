<?php

namespace Hexlet\Code;

$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}



use function Functional\flatten;

function toString($value)
{
    // эта функция делает так, чтобы true и false выводились как строка
     return trim(var_export($value, true), "'");
}

$file1 = '../file1.json';
$file2 = '../file2.json';
$jsonArray1 = json_decode(file_get_contents($file1), true);
$jsonArray2 = json_decode(file_get_contents($file2), true);

$jsonArray1 = array_map(fn($value) => toString($value), $jsonArray1);
$jsonArray2 = array_map(fn($value) => toString($value), $jsonArray2);

$equalKeys = array_intersect(array_keys($jsonArray1), array_keys($jsonArray2));

$keysEqualValues = array_filter($equalKeys, fn($key) => $jsonArray1[$key] === $jsonArray2[$key]);

$filteredEqual =  array_filter($jsonArray1, fn($key) => in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);
$filteredJson1 =  array_filter($jsonArray1, fn($key) => !in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);
$filteredJson2 =  array_filter($jsonArray2, fn($key) => !in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);

$arrayStringsEqual = array_map(fn($key) => "    {$key} : {$filteredEqual[$key]}", array_keys($filteredEqual));
$arrayStrings2 = array_map(fn($key) => "  - {$key} : {$filteredJson2[$key]}", array_keys($filteredJson2));
$arrayStrings1 = array_map(fn($key) => "  + {$key} : {$filteredJson1[$key]}", array_keys($filteredJson1));
$result = array_merge($arrayStringsEqual, $arrayStrings2, $arrayStrings1);

const INDEX_FIRST_CHAR_KEY = 4;

usort($result, fn($a, $b) => $a[INDEX_FIRST_CHAR_KEY] <=> $b[INDEX_FIRST_CHAR_KEY]);

$stringFromArray = implode("\n", $result);

print_r("{\n{$stringFromArray}\n}");
