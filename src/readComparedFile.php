<?php

namespace Hexlet\Code;

function readComparedFile(string $filepath): string
{
    return (realpath($filepath)) ? file_get_contents(realpath($filepath), true) : '';
}
