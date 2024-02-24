<?php

namespace Hexlet\Code;

use function PHPUnit\Framework\isNull;

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
        $acc[$key] = ($key[0] === '+' || $key[0] === '-') ? '[complex value]' : $incoming[$key];
        return $acc;
    }, []);

    $dfs = function ($changedIncoming, $newKeyArray = []) use (&$dfs) {
        if (!is_array($changedIncoming)) {
            $newKeyArray[] = $changedIncoming;
            return $newKeyArray;
        } elseif (count($changedIncoming) === 1) {
            $changedIncoming = '[complex value]';
            $newKeyArray[] = $changedIncoming;
            return $newKeyArray;
        }


        $new = array_map(function ($key) use ($changedIncoming, $newKeyArray, &$dfs) {
            $prefix = $key[0];
            $sign = $newKeyArray[0] ?? null;
            $signStatus = ($sign === " ") || empty($newKeyArray);
            $newKeyArray[0] =  $signStatus ? $prefix : $sign;
            $actualKey = substr($key, 2);
            $newKeyArray[] = $actualKey;
            return $dfs($changedIncoming[$key], $newKeyArray);
        }, array_keys($changedIncoming));

        return $new;
    };

    $flatten = function ($needsFolded, &$newResult) use (&$flatten) {
        foreach ($needsFolded as $item) {
            if (is_array($item)) {
                $flatten($item, $newResult);
            } else {
                $status = in_array($needsFolded, $newResult);
                if (!$status) {
                    $newResult[] = $needsFolded;
                }
            }
        }
        return $newResult;
    };

    $newResult = [];
    $sourceArray = $flatten($dfs($changedIncoming), $newResult);

    $isEqualKeys = function ($old, $element) {
        $sliceOld = array_slice($old, 1, -1);
        $sliceElement = array_slice($element, 1, -1);
        return $sliceOld === $sliceElement;
    };

    $sourceArray[] = [];

    $old = [];
    $changedArray = array_reduce($sourceArray, function ($acc, $element) use (&$old, $isEqualKeys) {
        if (empty($old)) {
            $old = $element;
        } else {
            if ($isEqualKeys($old, $element)) {
                $old[0] = "changed";
                $acc[] = [...$old, $element[count($element) - 1]];
                $old = [];
            } else {
                $acc[] = $old;
                $old = $element;
            }
        }
        return $acc;
    }, []);


    $flattenKey = function ($item, $numbersValue) {
        $sliceItem = array_slice($item, 1, - $numbersValue);
        $key = implode(".", $sliceItem);
        return "'{$key}'";
    };

    $stringArray = array_reduce($changedArray, function ($acc, $item) use ($flattenKey) {
        if ($item[0] === "+") {
            $key = $flattenKey($item, 1);
            $value = toStringNew($item[count($item) - 1]);
            $acc[] = "Property {$key} was added with value: {$value}";
        } elseif (($item[0] === "-")) {
            $key = $flattenKey($item, 1);
            $acc[] = "Property {$key} was removed";
        } elseif (($item[0] === "changed")) {
            $key = $flattenKey($item, 2);
            $value1 = toStringNew($item[count($item) - 2]);
            $value2 = toStringNew($item[count($item) - 1]);
            $acc[] = "Property {$key} was updated. From {$value1} to {$value2}";
        }
        return $acc;
    }, []);

    return implode("\n", $stringArray) . "\n";
}
