<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\genDiff;
use function Hexlet\Code\stylish;

class GenDiffTest extends TestCase
{
    public function testGendiff(): void
    {

        $exeptedArray1 = [
            '- follow' => false,
            '  host' => 'hexlet.io',
            '- proxy' => '123.234.53.22',
            '- timeout' => 50,
            '+ timeout' => 20,
            '+ verbose' => true
        ];

        $exeptedArray2 = [
            '- follow' => false,
            '- host' => 'hexlet.io',
            '- proxy' => '123.234.53.22',
            '- timeout' => 50
        ];

        $exeptedArray3 = [
            '+ host' => 'hexlet.io',
            '+ timeout' => '20',
            '+ verbose' => true
        ];

        $array1 = [
            'host' => "hexlet.io",
            'timeout' => 50,
            'proxy' => "123.234.53.22",
            'follow' => false
        ];

        $array2 = [
            'timeout' => 20,
            'verbose' => true,
            'host' => "hexlet.io"
        ];
        $array3 = [];
        $array4 = [];

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
        $nestedArray1 = [
                        "common" => [
                                    "setting1" => "Value 1",
                                    "setting2" => 200,
                                    "setting3" => true,
                                    "setting6" => [
                                                  "key" => "value",
                                                  "doge" => [
                                                            "wow" => ""
                                                            ]
                                                  ]
                                    ],
                                    "group1" => [
                                                "baz" => "bas",
                                                "foo" => "bar",
                                                "nest" => [
                                                          "key" => "value"
                                                          ]
                                                ],
                                    "group2" => [
                                                "abc" => 12345,
                                                "deep" => [
                                                         "id" => 45
                                                          ]
                                                ]
                        ];

        $nestedArray2 = [
                        "common" => [
                                    "follow" => false,
                                    "setting1" => "Value 1",
                                    "setting3" => null,
                                    "setting4" => "blah blah",
                                    "setting5" => [
                                                  "key5" => "value5"
                                                  ],
                                    "setting6" => [
                                                  "key" => "value",
                                                  "ops" => "vops",
                                                  "doge" => [
                                                            "wow" => "so much"
                                                            ]
                                                  ]
                                    ],
                                    "group1" => [
                                                "foo" => "bar",
                                                "baz" => "bars",
                                                "nest" => "str"
                                                ],
                                    "group3" => [
                                                "deep" => [
                                                          "id" => [
                                                                  "number" => 45
                                                                  ]
                                                          ],
                                                "fee" => 100500
                                                ]
                        ];

        $this->assertEquals($exeptedArray1, genDiff($array1, $array2));
        $this->assertEquals($exeptedArray2, genDiff($array1, $array4));
        $this->assertEquals($exeptedArray3, genDiff($array3, $array2));
        $this->assertEquals([], genDiff($array3, $array4));
        $this->assertNull(genDiff(null, $array4));
        $this->assertEquals(($exeptedNestedResult), genDiff($nestedArray1, $nestedArray2));
    }
}
