<?php

namespace Hexlet\Code;

$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}

use function Hexlet\Code\parcer;

function genDiff(string $pathToFile1, string $pathToFil2): string
{
    return parcer($pathToFile1, $pathToFil2);
}
