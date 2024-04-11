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
        $t2path3 = __DIR__ . "/fixtures/file3.json";
        $t2path4 = __DIR__ . "/fixtures/file4.json";
        $yamlPath1 = __DIR__ . "/fixtures/file1.yaml";
        $yamlPath2 = __DIR__ . "/fixtures/file2.yaml";
        $jsonStylishFormat = rtrim(file_get_contents(__DIR__ . "/fixtures/testResult1.txt", 0, null, null), "\r\n");
        $shouldBe2 = rtrim(file_get_contents(__DIR__ . "/fixtures/testResult2.txt", 0, null, null), "\r\n");
        $yamlFormat = rtrim(file_get_contents(__DIR__ . "/fixtures/testYamlResult.txt", 0, null, null), "\r\n");
        $PlainFormat= rtrim(file_get_contents(__DIR__ . "/fixtures/testPlainResult.txt", 0, null, null), "\r\n");
        $this->assertEquals($jsonStylishFormat, gendiff($t1path1, $t1path2, 'stylish'));
        $this->assertEquals($shouldBe2, gendiff($t2path3, $t2path4, 'stylish'));
        $this->assertEquals($yamlFormat, gendiff($yamlPath1, $yamlPath2, 'stylish'));
        $this->assertEquals($PlainFormat, gendiff($t2path3, $t2path4, 'plain'));
    }
}