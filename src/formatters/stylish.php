<?php

namespace Differ\Formatters\Stylish;

function render(array $tree): string
{
    $strTree = stylish($tree);
    return $strTree;
}

function toString($value, $depth = 1)
{
    if (is_object($value)) {
        $arrayValue = json_decode((json_encode($value)), true);
        return stringify($arrayValue, $depth);
    }
    if (is_null($value)) {
        return 'null';
    }

    return trim(var_export($value, true), "'");
}

function stylish($value, string $replacer = ' ', int $spacesCount = 4): string
{
    $iter = function ($currentValue, $depth) use (&$iter, $replacer, $spacesCount) {
        if (!is_array($currentValue)) {
            return toString($currentValue);
        }

        $indentSize = $depth * $spacesCount - 2;
        $currentIndent = str_repeat($replacer, $indentSize);
        $bracketIndent = str_repeat($replacer, $indentSize - 2);

        $lines = array_map(function ($key, $val) use ($currentIndent, $iter, $depth) {
                $type = $val['type'];
                $name = $val['name'];

            switch ($type) {
                case 'nested':
                    $children = $iter($val['children'], $depth + 1);
                    return "{$currentIndent}  {$name}: {$children}";
                case 'removed':
                    $removed = toString($val['value'], $depth + 1);
                    return "{$currentIndent}- {$name}: {$removed}";
                case 'unchanged':
                    $unchanged =  toString($val['value'], $depth + 1);
                    return "{$currentIndent}  {$name}: {$unchanged}";
                case 'changed':
                    $valueBefore = toString($val['valueBefore'], $depth + 1);
                    $valueAfter = toString($val['valueAfter'], $depth + 1);
                    return "{$currentIndent}- {$name}: {$valueBefore}\n{$currentIndent}+ {$name}: {$valueAfter}";
                case 'added':
                    $added = toString($val['value'], $depth + 1);
                    return "{$currentIndent}+ {$name}: {$added}";
            }
        },
        array_keys($currentValue),
        $currentValue);

        $result = ['{', ...$lines, "{$bracketIndent}}"];

        return implode("\n", $result);
    };

    return $iter($value, 1);
}

function stringify($value, int $d, int $spacesCount = 4, string $replacer = ' '): string
{
    $iter = function ($currentValue, $depth) use (&$iter, $replacer, $spacesCount) {
        if (!is_array($currentValue)) {
            return toString($currentValue);
        }
        $indentSize = $depth * $spacesCount;
        $currentIndent = str_repeat($replacer, $indentSize);
        $bracketIndent = str_repeat($replacer, $indentSize - 4);

        $lines = array_map(
            fn($key, $val) => "{$currentIndent}{$key}: {$iter($val, $depth + 1)}",
            array_keys($currentValue),
            $currentValue
        );

        $result = ['{', ...$lines, "{$bracketIndent}}"];

        return implode("\n", $result);
    };

    return $iter($value, $d);
}
