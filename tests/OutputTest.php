<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\output;

class OutputTest extends TestCase
{
    public function testOutputBase(): void
    {
        $this->expectOutputString('example');

        output('example');
    }

    public function testOutputNull(): void
    {

        $this->expectOutputString("There is no file or files with that name in the current directory!\n\n");

        output(null);
    }
}
