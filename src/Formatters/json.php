<?php

namespace Hexlet\Code;

function json(array $incoming): string
{
    return json_encode($incoming) . "\n";
}
