<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\genDiff;

class GenDiffTest extends TestCase
{
    // Метод, функция определенная внутри класса
    // Должна начинаться со слова test
    // public – чтобы PHPUnit мог вызвать этот тест снаружи
    public function testGendiff(): void
    {
        $exepted = "{\n  - follow : false\n    host : hexlet.io\n  - proxy : 123.234.53.22\n  - timeout : 50\n  + timeout : 20\n  + verbose : true\n}\n";

        $this->assertEquals($exepted, genDiff('fixtures/file1.json', 'fixtures/file2.json'));
        //$this->assertEquals('olleh', reverseString('hello'));
    }
}
