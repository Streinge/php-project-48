<?php

namespace Hexlet\Code;

function readFile(string $filepath): string|null
{
    return (realpath($filepath)) ? file_get_contents(realpath($filepath), true) : null;
}
