<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\genDiff;

class GenDiffTest extends TestCase
{
    public function testGendiff(): void
    {

        $exepted = function (array $exeptedArray): string {
            $parts = ["{", ...$exeptedArray, "}\n"];
            $stringFromArray = implode("\n", $parts);
            return $stringFromArray;
        };

        $exeptedArray1 = [
            '  - follow : false',
            '    host : hexlet.io',
            '  - proxy : 123.234.53.22',
            '  - timeout : 50',
            '  + timeout : 20',
            '  + verbose : true'
        ];

        $exeptedArray2 = [
            '  - follow : false',
            '  - host : hexlet.io',
            '  - proxy : 123.234.53.22',
            '  - timeout : 50'
        ];

        $exeptedArray3 = [
            '  + host : hexlet.io',
            '  + timeout : 20',
            '  + verbose : true'
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

        $pathDir = __DIR__;
        //"{$pathDir}/fixtures/file1.json"
        //"{$pathDir}/fixtures/file2.json"
        $this->assertEquals($exepted($exeptedArray1), genDiff($array1, $array2));
        $this->assertEquals($exepted($exeptedArray2), genDiff($array1, $array4));
        $this->assertEquals($exepted($exeptedArray3), genDiff($array3, $array2));
        $this->assertEquals("", genDiff($array3, $array4));
        $this->assertNull(genDiff(null, $array4));
    }
}
