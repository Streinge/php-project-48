<?php

namespace Hexlet\Code;

use function Functional\id;

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

    $sourceArrayNew = $flatt($dfs($changedIncoming));

    $onlyKeys = array_map(fn($value) => array_slice($value, 1, -1), $sourceArrayNew);
    $uniqueOnlyKeys = array_unique($onlyKeys, SORT_REGULAR);
    $nonUniqueKeys = array_diff_key($onlyKeys, $uniqueOnlyKeys);
    $uniqueIndexes = array_keys($uniqueOnlyKeys);

    $uniqueSourceArray = array_filter(array_map(
        function ($index) use ($sourceArrayNew, $uniqueIndexes) {
            return in_array($index, $uniqueIndexes, true) ? $sourceArrayNew[$index] : [];
        },
        array_keys($sourceArrayNew)
    ));

    $indexesNonUnique = array_keys($nonUniqueKeys);

    $firstIndexes = array_map(fn($index) => $index - 1, $indexesNonUnique);
    $changedArrayNew = array_reduce(
        array_keys($uniqueSourceArray),
        function ($acc, $index) use ($uniqueSourceArray, $sourceArrayNew, $firstIndexes) {
            if (in_array($index, $firstIndexes, true)) {
                $valueWithoutSign = array_slice($uniqueSourceArray[$index], 1);
                $lastIndex = count($sourceArrayNew[$index + 1]) - 1;
                $updatedValue = $sourceArrayNew[$index + 1][$lastIndex];
                return [...$acc, ['changed', ...$valueWithoutSign, $updatedValue]];
            } else {
                return [...$acc, $uniqueSourceArray[$index]];
            }
        },
        []
    );
    $flattenKey = function ($item, $numbersValue) {
        $sliceItem = array_slice($item, 1, (int) (- $numbersValue));
        $key = implode(".", $sliceItem);
        return "'{$key}'";
    };

    $stringArray = array_reduce($changedArrayNew, function ($acc, $item) use ($flattenKey) {
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
