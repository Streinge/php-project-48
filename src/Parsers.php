<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function jsonInArray(string $filepath): array|null
{
    $dataFile1 = readFile($filepath);
    $jsonArray1 = json_decode($dataFile1, true) ?? [];

    return (!is_null($dataFile1)) ? $jsonArray1 : null;
}

function yamlInArray(string $filepath): array|null
{
    $dataFile1 = readFile($filepath);

    return (!is_null($dataFile1)) ? Yaml::parse($dataFile1) : null;
}
