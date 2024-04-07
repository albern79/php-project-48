<?php

namespace Differ\Formatters\Plain;

function render(array $tree): string
{
    $strTree = plain($tree);
    return $strTree;
}

function plain($tree)
{
    return 'hello';
}
