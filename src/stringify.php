<?php

namespace Hexlet\Code;

function stringify($value, string $replacer = ' ', int $spacesCount = 1): string
{
    // Функция аналог JavaScript содержит метод JSON.stringify() для приведения к строке любого значения.
    // создается анонимная функция $iter значение которой по ссылке используется в функции
    // с начала работы коды никакие данные в нее не передаются, то есть она вызывается позже
    $iter = function ($currentValue, $depth) use (&$iter, $replacer, $spacesCount) {
        // если текущее значение не массив то преобразуется к строке
        // и возвращается - это терминальное условие
        if (!is_array($currentValue)) {
            return toString($currentValue);
        }
        // ДАЛЬШЕ ЕСЛИ $currentValue - МАССИВ
        // размер отступа равен произведению глубины на счетчик отступов
        $indentSize = $depth * $spacesCount;
        // вычисляется текущий отступ
        $currentIndent = str_repeat($replacer, $indentSize);
        // вычисляется отступ кавычек, он меньше на величину счетчика отступов
        $bracketIndent = str_repeat($replacer, $indentSize - $spacesCount);

        // каждый элемент массива отображается в массив как отформатированная строка
        // при этом array_map вызывается по двум массивам array_keys($currentValue) и
        // $currentValue, которые одновременно подаются в callback функцию как
        // $key, $val !!! то есть одновременно перебираются
        $lines = array_map(
            fn($key, $val) => "{$currentIndent}{$key}: {$iter($val, $depth + 1)}",
            array_keys($currentValue),
            $currentValue
        );
        // Здесь происходит распаковка массива $lines в массив уже с открывающими и завершающими
        // кавычками
        $result = ['{', ...$lines, "{$bracketIndent}}"];

        // и возвращается уже строка с переводом строки

        return implode("\n", $result);
    };
    // при возврате происходит вызов функции $iter со значением, с массивом равным исходному
    // и параметром $depth, то есть глубина равным 1.
    return $iter($value, 1);
}
