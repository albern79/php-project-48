<?php

namespace Differ\Differ;

function genDiff($pathToFile1, $pathToFile2, $format)
{
    $file1 = file_get_contents($pathToFile1, true);
    $file2 = file_get_contents($pathToFile2, true);
    $data = (json_decode($file1, JSON_OBJECT_AS_ARRAY));
    $data2 = (json_decode($file2, true));
    $tempResult = [];
    foreach ($data as $key => $value) {
        if ($value === false) {
            $value = "false";
        }
        if (array_key_exists($key, $data2)) {
            if ($value === $data2[$key]) {
                $tempResult[] = "   " . $key . ': ' . $value;
            } else {
                $tempResult[] = " - " . $key . ': ' . $value;
                $tempResult[] = " + " . $key . ': ' . $data2[$key];
            }
        } else {
            $tempResult[] = " - " . $key . ': ' . $value;
        }
    }

    $diffKeyData2 = array_diff_key($data2, $data);
    foreach ($diffKeyData2 as $key => $value) {
        if ($value === true) {
            $value = "true";
        }
        $tempResult[] = " + " . $key . ': ' . $value;
    }

    usort($tempResult, function ($a, $b) {
        return substr($a, 3, 1) <=> substr($b, 3, 1);
    });


    $tempResult = str_replace("'", '', $tempResult);
    $finalResult = "{" . "\n" . implode("\n", $tempResult) . "\n" . "}";
    return $finalResult;
}
