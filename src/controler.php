<?php

namespace Hexlet\Code;

use Hexlet\Code\jsonInArray;
use Hexlet\Code\yamlInArray;
use Hexlet\Code\genDiff;

function controler(string $filepath1, string $filepath2, callable $fn): string|null
{
    $arrayFile = function (string $filepath1): array|null {
        $ext = pathinfo($filepath1, PATHINFO_EXTENSION);
        if ($ext === 'json') {
            return jsonInArray($filepath1);
        } elseif ($ext = 'yml' || $ext = 'yaml') {
            return yamlInArray($filepath1);
        } else {
            return null;
        }
    };
    $isMyNull = is_null($arrayFile($filepath1)) || is_null($arrayFile($filepath2));
    $errorStr = "Не поддерживается сравнение таких файлов";
    return (!$isMyNull) ? $fn(genDiff($arrayFile($filepath1), $arrayFile($filepath2))) : $errorStr;
}
