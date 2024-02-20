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
        $errorNessage = "There is no file with that name or unknown file extension in the current directory!\n\n";
        $this->expectOutputString($errorNessage);

        output(null);
    }
}
