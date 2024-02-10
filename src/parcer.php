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
// эта функция делает так, чтобы true и false выводились как строка
{
     return trim(var_export($value, true), "'");
}

$file1 = '../file1.json';
$file2 = '../file2.json';
$jsonArray1 = json_decode(file_get_contents($file1), true);
$jsonArray2 = json_decode(file_get_contents($file2), true);

$keys1 = array_keys($jsonArray1);
$keys2 = array_keys($jsonArray2);

$allKeys = array_unique(array_merge($keys1, $keys2));

sort($allKeys);



$element = function ($key) use ($jsonArray1, $jsonArray2, $keys1, $keys2) {

    $value1 = (array_key_exists($key, $jsonArray1)) ? toString($jsonArray1[$key]) : null;

    $value2 = (array_key_exists($key, $jsonArray2)) ? toString($jsonArray2[$key]) : null;

    return ($value1 && $value2) ? [[$key, $value2], [$key, $value1]] : null;

    /*if ($value1 && $value2) {
        if ($value1 === $value2) {
            return ["    {$key} : {$value1}"];
        } else {
            return ["  - {$key} : {$value2}", "  + {$key} : {$value1}"];
        }
    } elseif ($value1) {
        return ["  + {$key} : {$value1}"];
    } else {
        return ["  - {$key} : {$value2}"];
    }*/
};




//$result = array_map(fn($key) => array_key_exists($key, $jsonFile2) <=> array_key_exists($key, $jsonFile1), $allKeys);
//$new = array_combine($allKeys, $result);

$equalKeys = array_intersect($keys1, $keys2);
$keysEqualValues = array_filter($equalKeys, fn($key) => $jsonArray1[$key] === $jsonArray2[$key]);

$filteredJson1 =  array_filter($jsonArray1, fn($key) => !in_array($key, $keysEqualValues), ARRAY_FILTER_USE_KEY);


//$string = implode("\n", $result);
print_r($filteredJson1);
