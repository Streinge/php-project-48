<?php

namespace Hexlet\Code;

function readComparedFile(string $filepath): string|null
{
    return (realpath($filepath)) ? file_get_contents(realpath($filepath), true) : null;
}
