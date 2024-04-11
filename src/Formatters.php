<?php

namespace Differ\Formatters;

function format(string $format, array $tree): string
{
    var_dump($format);
    switch ($format) {
        case 'plain':
            return Plain\render($tree);
        case 'json':
            return Json\render($tree);
        case 'stylish':
            return Stylish\render($tree);
        default:
            throw new \Exception('NO format');
    }
}
