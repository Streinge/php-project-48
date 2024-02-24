<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function jsonInArray(string $filepath): array|null
{
    $dataFile1 = readComparedFile($filepath);
    $jsonArray1 = json_decode($dataFile1, true) ?? [];

    return (!is_null($dataFile1)) ? $jsonArray1 : null;
}

function yamlInArray(string $filepath): array|null
{
    $dataFile1 = readComparedFile($filepath);
    return (!is_null($dataFile1)) ? Yaml::parse($dataFile1) : null;
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
