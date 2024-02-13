<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\genDiff;

class GenDiffTest extends TestCase
{
    public function testGendiff(): void
    {

        $exepted = function (array $exeptedArray): string {
            $exeptedStr = implode("\n", $exeptedArray);
            return "{\n{$exeptedStr}\n}\n";
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

        $this->assertEquals($exepted($exeptedArray1), genDiff('fixtures/file1.json', 'fixtures/file2.json'));
        $this->assertEquals($exepted($exeptedArray2), genDiff('fixtures/file1.json', 'fixtures/file4.json'));
        $this->assertEquals($exepted($exeptedArray3), genDiff('fixtures/file3.json', 'fixtures/file2.json'));
        $this->assertEmpty(genDiff('fixtures/file3.json', 'fixtures/file4.json'));
    }
}
