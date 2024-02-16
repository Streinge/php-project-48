<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\readFile;

class ReadFileTest extends TestCase
{
    public function testReadFile(): void
    {
        $pathDir = __DIR__;

        $exepted1 = file_get_contents("{$pathDir}/fixtures/file1.json", true);
        $exepted2 = file_get_contents("{$pathDir}/fixtures/file2.json", true);
        $this->assertEquals($exepted1, readfile("{$pathDir}/fixtures/file1.json"));
        $this->assertEquals($exepted2, readfile("{$pathDir}/fixtures/file2.json"));
        $this->assertEquals("", readFile("{$pathDir}/fixtures/file3.json"));
        $this->assertNull(readFile("{$pathDir}/fixtures/file5.json"));
    }
}
