<?php

namespace Hexlet\Code;

function readComparedFile(string $filepath): string
{
    $isMyFalse = realpath($filepath) === false;
    return (!$isMyFalse) ? file_get_contents($filepath, true) : '';
}
