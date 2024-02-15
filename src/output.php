<?php

namespace Hexlet\Code;

function output(string|null $value): void
{
    if (is_null($value)) {
        echo "There is no file or files with that name in the current directory!\n";
        echo "\n";
    } else {
        print_r($value);
    }
}
