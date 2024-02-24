<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function jsonInArray(string $filepath): array|null
{
    $dataFile1 = readComparedFile($filepath);
    $jsonArray1 = json_decode($dataFile1, true) ?? [];

    return $jsonArray1;
}

function yamlInArray(string $filepath): array|null
{
    $dataFile1 = readComparedFile($filepath);
    return Yaml::parse($dataFile1);
}

function parser(string $filepath)
{
    $extension = pathinfo($filepath, PATHINFO_EXTENSION);
    switch ($extension) {
        case 'json':
            return jsonInArray($filepath);

        case 'yaml':
        case 'yml':
            return yamlInArray($filepath);

        default:
            throw new \Exception("Format $extension is not supported!");
    }
}
