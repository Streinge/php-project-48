<?php

namespace Hexlet\Code;

function json(array $incoming): string|null
{
    return (!json_encode($incoming)) ? null : json_encode($incoming) . "\n";
}
