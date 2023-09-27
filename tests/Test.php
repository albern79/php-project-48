<?php

namespace Gendiff\PHPUnit\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class Test extends TestCase
{
    public function testGenDiff(): void
    {
        $t1path1 = __DIR__ . "/fixtures/file1.json";
        $t1path2 = __DIR__ . "/fixtures/file2.json";
        $shouldBe1 = rtrim(file_get_contents(__DIR__ . "/fixtures/testResult1.txt", 0, null, null), "\r\n");
        $this->assertEquals($shouldBe1, gendiff($t1path1, $t1path2, 'stylish'));
    }
}