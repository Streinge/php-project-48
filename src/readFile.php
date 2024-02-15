<?php

namespace Hexlet\Code;

function readFile(string $filepath, string $nameDirWithFunction): string|null
{
    /* if the code with the triggering function is located in the 'src'
    directory, then the files to be checked must be placed in the root
    directory of the project, and if the code is run from the test
    function, then in /tests/fixes*/

    $lenghtDirname = strlen('src') + 1;
    $directoryProject = substr(__DIR__, 0, - $lenghtDirname);
    $filename = pathinfo($filepath, PATHINFO_BASENAME);

    if ($nameDirWithFunction === 'src') {
        $parts = [$directoryProject, $filename];
    } elseif ($nameDirWithFunction === 'tests') {
        $parts = [$directoryProject, 'tests/fixtures', $filename];
    } else {
        return false;
    }

    return (realpath(implode('/', $parts))) ? file_get_contents(realpath(implode('/', $parts)), true) : null;
}
