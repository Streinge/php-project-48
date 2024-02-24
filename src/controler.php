<?php

namespace Hexlet\Code;

use Hexlet\Code\jsonInArray;
use Hexlet\Code\yamlInArray;
use Hexlet\Code\genDiff;
use Hexlet\Code\stylish;
use Hexlet\Code\plain;

function controler(string $filepath1, string $filepath2, string $format): string|null
{
    $arrayFile = function (string $filepath1): array|null {
        $ext = pathinfo($filepath1, PATHINFO_EXTENSION);
        if ($ext === 'json') {
            return jsonInArray($filepath1);
        } elseif ($ext === 'yml' || $ext === 'yaml') {
            return yamlInArray($filepath1);
        } else {
            return null;
        }
    };

    if ($format === 'stylish') {
        $fn = fn($array) => stylish($array);
    } elseif ($format === 'plain') {
        $fn = fn($array) => plain($array);
    }

    $isMyNull = is_null($arrayFile($filepath1)) || is_null($arrayFile($filepath2));

    return !$isMyNull ? genDiff($arrayFile($filepath1), $arrayFile($filepath2), $fn) : null;
}
