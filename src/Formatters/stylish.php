<?php

namespace Hexlet\Code;

function toString(mixed $value): string
{
    return is_null($value) ? 'null' : trim(var_export($value, true), "'");
}

function stylish($value, string $replacer = ' ', int $spacesCount = 2): string
{

    $iter = function ($currentValue, $depth) use (&$iter, $replacer, $spacesCount) {

        if (!is_array($currentValue)) {
            return toString($currentValue);
        }

        $indentSize = $depth * $spacesCount;

        $currentIndent = str_repeat($replacer, $indentSize);

        $bracketIndent = str_repeat($replacer, $indentSize - $spacesCount);

        $lines = array_map(
            fn($key, $val) => "{$currentIndent}{$key}: {$iter($val, $depth + 2)}",
            array_keys($currentValue),
            $currentValue
        );

        $result = ['{', ...$lines, "{$bracketIndent}}"];

        return implode("\n", $result) . "\n";
    };
    return $iter($value, 1);
}
