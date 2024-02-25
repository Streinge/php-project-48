<?php

namespace Hexlet\Code;

function toStringNew(mixed $value): string
{
    // эта функция делает так, чтобы true и false выводились как строка
    if ($value === '[complex value]') {
        return $value;
    } elseif (is_null($value)) {
        return 'null';
    }
    $newValue =  trim(var_export($value, true), "'");
    return is_string($value) ? "'{$newValue}'" : $newValue;
}

function plain(array $incoming): string
{
    $changedIncoming = array_reduce(array_keys($incoming), function ($acc, $key) use ($incoming) {
        $element = [$key =>
            ($key[0] === '+' || $key[0] === '-')
            ? '[complex value]' : $incoming[$key]];
        return array_merge($acc, $element);
    }, []);

    $dfs = function ($changedIncoming, $newKeyArray = []) use (&$dfs) {
        if (!is_array($changedIncoming)) {
            return [...$newKeyArray, $changedIncoming];
        } elseif (count($changedIncoming) === 1) {
            return [...$newKeyArray, '[complex value]'];
        }


        $new = array_map(function ($key) use ($changedIncoming, $newKeyArray, &$dfs) {
            $prefix = $key[0];
            $sign = $newKeyArray[0] ?? null;
            $signStatus = ($sign === " " || $newKeyArray === []);
            $newPrefix =  $signStatus ? $prefix : $sign;
            $actualKey = substr($key, 2);
            $arrayWhithoutPrefix = ($newKeyArray !== []) ? array_slice($newKeyArray, 1) : [];
            return $dfs($changedIncoming[$key], [$newPrefix, ...$arrayWhithoutPrefix, $actualKey]);
        }, array_keys($changedIncoming));

        return $new;
    };

    $flatt = function ($needsFolded) use (&$flatt) {
        $fn = array_reduce($needsFolded, function ($acc, $item) use (&$flatt) {
            if (is_array($item) && !is_array($item[0])) {
                return array_merge($acc, [$item]);
            } else {
                return array_merge($acc, $flatt($item));
            }
        }, []);
        return $fn;
    };

    $sourceArray = [...$flatt($dfs($changedIncoming)), []];

    $isEqualKeys = function ($old, $element) {
        $sliceOld = array_slice($old, 1, -1);
        $sliceElement = array_slice($element, 1, -1);
        return $sliceOld === $sliceElement;
    };
    //var_dump($sourceArray);
    $old = [];

    $changeOldToElement = function ($element) {
        return $element;
    };
    # находим элементы в которых были изменения
    $changedArray = array_reduce(
        $sourceArray,
        function ($acc, $element) use (&$old, $isEqualKeys, $changeOldToElement) {
        # для этого хочу сравнить элементы массивов без префикса и значения (это будущие составные ключи)
            if ($old === []) {
                $old = $changeOldToElement($element);
            } else {
                # здесь если составные ключи равны
                if ($isEqualKeys($old, $element)) {
                    # здесь убираю префикс из будущего составного ключа
                    $oldWhithoutPrefix = array_slice($old, 1);
                    # и поскольку сравнение закончилось - пара найдена то начинаем поиск занова old = []
                    $old = $changeOldToElement([]);
                    # возвращаю массив с новым элементом массива
                    return [...$acc, ["changed", ...$oldWhithoutPrefix, $element[count($element) - 1]]];
                } else {
                    # если составные ключи не совпадают, то возвращаю элемент со старым элементом массива
                    $newOld = $old;
                    $old = $changeOldToElement($element);
                    return [...$acc, $newOld];
                }
            }
            return $acc;
        },
        []
    );

    $flattenKey = function ($item, $numbersValue) {
        $sliceItem = array_slice($item, 1, (int) (- $numbersValue));
        $key = implode(".", $sliceItem);
        return "'{$key}'";
    };

    $stringArray = array_reduce($changedArray, function ($acc, $item) use ($flattenKey) {
        if ($item[0] === "+") {
            $key = $flattenKey($item, 1);
            $value = toStringNew($item[count($item) - 1]);
            return [...$acc, "Property {$key} was added with value: {$value}"];
        } elseif (($item[0] === "-")) {
            $key = $flattenKey($item, 1);
            return [...$acc, "Property {$key} was removed"];
        } elseif (($item[0] === "changed")) {
            $key = $flattenKey($item, 2);
            $value1 = toStringNew($item[count($item) - 2]);
            $value2 = toStringNew($item[count($item) - 1]);
            return [...$acc, "Property {$key} was updated. From {$value1} to {$value2}"];
        }
        return $acc;
    }, []);

    return implode("\n", $stringArray) . "\n";
}
