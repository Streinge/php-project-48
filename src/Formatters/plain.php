<?php

namespace Hexlet\Code;

function toString(mixed $value): string
{
    // эта функция делает так, чтобы true и false выводились как строка
     return trim(var_export($value, true), "'");
}

function plain(array|null $incoming, &$result, $oldKey = '')
{
    $currentKeys = array_keys($incoming);
    foreach ($currentKeys as $key) {
        $prefix = (!$key[0]) ? " " : $key[0];
        $keyValue = substr($key, 2);
        if ($prefix === " ") {
            $newKey = "{$oldKey}.{$keyValue}";
        } else {
            $valueKeyOld = substr($oldKey, 1);
            $newKey = "{$prefix}.{$valueKeyOld}.{$keyValue}";
        }
        var_dump($newKey);
        var_dump($key);
        var_dump($incoming[$key]);
        if (is_array($incoming[$key])) {
            plain($incoming[$key], $result, $newKey);
        } else {
            $result[$newKey] = $incoming[$key];
        }
    }
    return $result;
}

$exeptedNestedResult = [
    '  common' => [
                '+ follow' => false,
                '  setting1' => 'Value 1',
                '- setting2' => 200,
                '- setting3' => true,
                '+ setting3' => null,
                '+ setting4' => 'blah blah',
                '+ setting5' => [
                               '  key5' =>  'value5'
                                ],
                '  setting6' => [
                              '  doge' => [
                                        '- wow' => '',
                                        '+ wow' => 'so much'
                                        ],
                              '  key' => 'value',
                              '+ ops' => 'vops'
                                ]
                ],
     '  group1' => [
                   '- baz' => 'bas',
                   '+ baz' => 'bars',
                   '  foo' => 'bar',
                   '- nest' => [
                               '  key' => 'value'
                               ],
                   '+ nest' => 'str'
                   ],
     '- group2' => [
                   '  abc' => 12345,
                   '  deep' => [
                               '  id' => 45
                               ]
                   ],
     '+ group3' => [
                   '  deep' => [
                             '  id' => [
                                     '  number' => 45
                                     ]
                             ],
                   '  fee' => 100500
                   ]
];


$result = [];
print_r(plain($exeptedNestedResult, $result));
