<?php

namespace Differ\Formatters\Plain;

function render(array $tree): string
{
    return implode("\n", buildPlain($tree));
}

function stringify($value): string
{
    if (is_null($value)) {
        return 'null';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_object($value) || is_array($value)) {
        return "[complex value]";
    }

    return is_numeric($value) ? (string)$value : "'$value'";
}


function buildPlain(array $tree, string $path = ""): array
{
    $dataPlain = array_reduce($tree, function ($acc, $node) use ($path) {
        $type = $node['type'];
        $fullPath = "{$path}{$node['name']}";
        switch ($type) {
            case 'nested':
                $children = buildPlain($node['children'], "{$fullPath}.");
                return array_merge($acc, $children);
            case 'changed':
                $valueBefore = stringify($node['valueBefore']);
                $valueAfter = stringify($node['valueAfter']);
                return [...$acc, "Property '{$fullPath}' was updated. From {$valueBefore} to {$valueAfter}"];
            case 'removed':
                return [...$acc, "Property '{$fullPath}' was removed"];
            case 'added':
                $value = stringify($node['value']);
                return [...$acc, "Property '{$fullPath}' was added with value: {$value}"];
        }
        return $acc;
    }, []);
    return $dataPlain;
}
