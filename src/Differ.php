<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
//use function Funct\Collection\sortBy;
use function Functional\sort;
use function Differ\Formatters\format;

function genDiff(string $pathToFileBefore, string $pathToFileAfter, string $format = 'stylish'): string
{
    $data1 = parse(getDataPath($pathToFileBefore));
    $data2 = parse(getDataPath($pathToFileAfter));
    $tree = getTree($data1, $data2);
    return format($format, $tree);
}

function getDataPath(string $pathToFile): array
{
    if (file_exists($pathToFile)) {
        $extension = strtolower(pathinfo($pathToFile, PATHINFO_EXTENSION));
        $data = file_get_contents($pathToFile, true);
        return ['extension' => $extension, 'data' => $data];
    } else {
        throw new \Exception("No File");
    }
}

function getTree($before, $after)
{
    $keys1 = array_keys(get_object_vars($before));
    $keys2 = array_keys(get_object_vars($after));
    $keys = array_unique(array_merge($keys1, $keys2));
    $sortedUnicKey = array_values(sort($keys, fn ($left, $right) => strcmp($left, $right)));

    $tree = array_map(function ($key) use ($before, $after) {
        if (! property_exists($after, $key)) {
            return [
                'name' => $key,
                'type' => 'removed',
                'value' => $before->$key
            ];
        }
        if (! property_exists($before, $key)) {
            return [
                'name' => $key,
                'type' => 'added',
                'value' => $after->$key
            ];
        }
        if (is_object($before->$key) && is_object($after->$key)) {
            return [
                'name' => $key,
                'type' => 'nested',
                'children' => getTree($before->$key, $after->$key)
            ];
        }
        if ($before->$key !== $after->$key) {
            return [
                'name' => $key,
                'type' => 'changed',
                'valueBefore' => $before->$key,
                'valueAfter' => $after->$key
            ];
        }
            return [
                'name' => $key,
                'type' => 'unchanged',
                'value' => $before->$key
            ];
    }, $sortedUnicKey);
    return $tree;
}
