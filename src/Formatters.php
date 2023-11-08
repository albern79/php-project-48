<?php

namespace Differ\Formatters;

function format(string $format, array $tree): string
{
    var_dump($tree);
    switch ($format) {
        case 'plane':
        case 'json':
            return Json\render($tree);
        case 'yaml':
        default:
            throw new \Exception('not format');
    }
    return 'hello';
}
