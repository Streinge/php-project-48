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

        $this->assertEquals($exepted($exeptedArray1), genDiff('file1.json', 'file2.json'));
        $this->assertEquals($exepted($exeptedArray2), genDiff('file1.json', 'file4.json'));
        $this->assertEquals($exepted($exeptedArray3), genDiff('file3.json', 'file2.json'));
        $this->assertEmpty(genDiff('file3.json', 'file4.json'));
    }
}
