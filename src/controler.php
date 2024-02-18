<?php

namespace Hexlet\Code;

use Hexlet\Code\jsonInArray;
use Hexlet\Code\yamlInArray;
use Hexlet\Code\genDiff;
use Hexlet\Code\stringify;

function controler(string $filepath1, string $filepath2, callable $fn): string|null
{
    $ext1 = pathinfo($filepath1, PATHINFO_EXTENSION);
    $ext2 = pathinfo($filepath2, PATHINFO_EXTENSION);

    if ($ext1 === 'json' && $ext2 === 'json') {
        return $fn(genDiff(jsonInArray($filepath1), jsonInArray($filepath2)), ' ', 2);
    } elseif ($ext1 === 'yml' && $ext2 === 'yml') {
        return genDiff(yamlInArray($filepath1), yamlInArray($filepath2));
    } else {
        return "Не поддерживается сравнение таких файлов";
    }
}
