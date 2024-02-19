<?php

namespace Hexlet\Code;

function toString(mixed $value): string
{
    // эта функция делает так, чтобы true и false выводились как строка
     return trim(var_export($value, true), "'");
}

function stylish($value, string $replacer = ' ', int $spacesCount = 1): string
{
    // Функция аналог JavaScript содержит метод JSON.stringify() для приведения к строке любого значения.
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

        return implode("\n", $result);
    };
    return $iter($value, 1);
}
