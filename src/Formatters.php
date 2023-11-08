<?php

namespace Differ\Formatters;

function format(string $format, array $tree): string
{
    var_dump($tree);
    switch ($format) {
        case 'plane':
            return Plain\render($tree);
        case 'json':
            return Json\render($tree);
        case 'stylish':
            return Stylish\render($tree);
        default:
            throw new \Exception('not format');
    }
}
