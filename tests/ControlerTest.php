<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\controler;
use function Hexlet\Code\stylish;
use function Hexlet\Code\output;

class ControlerTest extends TestCase
{
    public function testControler(): void
    {

        $exeptedArray1 = [
            '- follow' => false,
            '  host' => 'hexlet.io',
            '- proxy' => '123.234.53.22',
            '- timeout' => 50,
            '+ timeout' => 20,
            '+ verbose' => true
        ];

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

        $pathDir = __DIR__;
        $pathFix = "{$pathDir}/fixtures/";
        $real1 = controler("{$pathFix}file1.json", "{$pathFix}file2.json", fn($array) => stylish($array, ' ', 2));
        $real2 = controler("{$pathFix}file1.yml", "{$pathFix}file2.yml", fn($array) => stylish($array, ' ', 2));
        $real3 = controler("{$pathFix}file1.json", "{$pathFix}file2.txt", fn($array) => stylish($array, ' ', 2));
        $real4 = controler("{$pathFix}file5.json", "{$pathFix}file6.json", fn($array) => stylish($array, ' ', 2));
        $real5 = controler("{$pathFix}file5.yml", "{$pathFix}file6.yml", fn($array) => stylish($array, ' ', 2));
        $this->assertEquals(stylish($exeptedArray1, ' ', 2), $real1);
        $this->assertEquals(stylish($exeptedArray1, ' ', 2), $real2);
        $this->assertNull($real3);
        $this->assertEquals(stylish($exeptedNestedResult, ' ', 2), $real4);
        //$this->assertEquals(stylish($exeptedNestedResult, ' ', 2), $real5);
    }
}
