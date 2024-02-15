<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\readFile;

class ReadFileTest extends TestCase
{
    public function testReadFile(): void
    {
        $exepted1 = file_get_contents('fixtures/file1.json', true);
        $exepted2 = file_get_contents('fixtures/file2.json', true);

        $this->assertEquals($exepted1, readfile('file1.json', 'tests'));
        $this->assertEquals($exepted1, readfile('file1.json', 'src'));
        $this->assertEquals($exepted2, readfile('file2.json', 'tests'));
        $this->assertEmpty(readFile('file3.json', 'tests'));
        $this->assertNull(readFile('file5.json', 'tests'));
        $this->assertNull(readFile('file1.json', 'unit'));
    }
}
