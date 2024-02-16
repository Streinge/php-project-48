<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\controler;
use function Hexlet\Code\output;

class ControlerTest extends TestCase
{
    public function testControler(): void
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

        $exepted2 = "Не поддерживается сравнение таких файлов";

        $pathDir = __DIR__;
        $pathFix = "{$pathDir}/fixtures/";
        $this->assertEquals($exepted($exeptedArray1), controler("{$pathFix}file1.json", "{$pathFix}file2.json"));
        $this->assertEquals($exepted($exeptedArray1), controler("{$pathFix}file1.yml", "{$pathFix}file2.yml"));
        $this->assertEquals($exepted2, controler("{$pathFix}file1.json", "{$pathFix}file2.txt"));
    }
}
