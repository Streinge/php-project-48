<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\readComparedFile;

class ReadFileTest extends TestCase
{
    public function testReadFile(): void
    {
        $pathDir = __DIR__;

        $exepted1 = file_get_contents("{$pathDir}/fixtures/file1.json", true);
        $exepted2 = file_get_contents("{$pathDir}/fixtures/file2.json", true);
        $this->assertEquals($exepted1, readComparedFile("{$pathDir}/fixtures/file1.json"));
        $this->assertEquals($exepted2, readComparedFile("{$pathDir}/fixtures/file2.json"));
        $this->assertEquals("", readComparedFile("{$pathDir}/fixtures/file3.json"));
        $this->assertEmpty(readComparedFile("{$pathDir}/fixtures/file_not_exist.json"));
    }
}
