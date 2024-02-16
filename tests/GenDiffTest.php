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

        $pathDir = __DIR__;

        $this->assertEquals($exepted($exeptedArray1), genDiff("{$pathDir}/fixtures/file1.json", "{$pathDir}/fixtures/file2.json"));
        $this->assertEquals($exepted($exeptedArray2), genDiff("{$pathDir}/fixtures/file1.json", "{$pathDir}/fixtures/file4.json"));
        $this->assertEquals($exepted($exeptedArray3), genDiff("{$pathDir}/fixtures/file3.json", "{$pathDir}/fixtures/file2.json"));
        $this->assertEmpty(genDiff("{$pathDir}/fixtures/file3.json", "{$pathDir}/fixtures/file4.json"));
        $this->assertNull(genDiff("{$pathDir}/fixtures/file5.json", "{$pathDir}/fixtures/file4.json"));
    }
}
