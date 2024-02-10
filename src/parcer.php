<?php

namespace Hexlet\Code;

$file1 = '../file1.json';
$file2 = '../file2.json';
$jsonFile1 = json_decode(file_get_contents($file1), true);
$jsonFile2 = json_decode(file_get_contents($file2), true);

$keys1 = array_keys($jsonFile1);
$keys2 = array_keys($jsonFile2);

$allKeys = array_unique(array_merge($keys1, $keys2));

sort($allKeys);



$element = function ($key) use ($jsonFile1, $jsonFile2, $keys1, $keys2) {
    if (array_key_exists($jsonFile1[$key])) {
        return $jsonFile2[$key];
    } elseif (empty($jsonFile2[$key])) {
        return $jsonFile1[$key];
    }
};

$result = array_map($element, $allKeys);
print_r($result);
