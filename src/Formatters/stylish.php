<?php

namespace Hexlet\Code;

function toString(mixed $value): string
{
    // эта функция делает так, чтобы true и false выводились как строка
     return trim(var_export($value, true), "'");
}

function getsArray($incoming, &$base, $str)
{
    $result = array_reduce(array_keys($incoming), function ($acc, $key) use ($incoming, $str, $base) {
        $value = is_bool($incoming[$key]) ? toString($incoming[$key]) : $incoming[$key];
        if (!is_array($value)) {
            $acc[] = "\n{$base}{$key}: {$value}";
        } else {
            $acc[] = "\n{$base}{$key}: {";
            $base .= str_repeat($str, 2);
            $value = getsArray($value, $base, $str);
            $acc = [...$acc, ...$value];
            $base = substr($base, 0, -1 * strlen($str));
            $acc[] = "\n{$base}}";
        }
        return $acc;
    }, []);

    return $result;
}

function stylish($incoming, string $replacer = ' ', int $counter = 2)
{
    if (!is_array($incoming)) {
        return $incoming;
    }

    $base = str_repeat($replacer, $counter);
    $result =  implode('', getsArray($incoming, $base, $base));

    return "{{$result}\n}\n";
}
