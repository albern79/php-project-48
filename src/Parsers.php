<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

/*function parse($dataFile)
{
    ['extension' => $extension, 'data' => $data] = $dataFile;
    $mapping = [
        'yaml' =>
            fn($data) => Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP),
        'json' =>
            fn($data) => json_decode($data, true),
    ];

    return $mapping[$extension]($data);
}
*/

function parse(array $dataFile)
{
    ['extension' => $extension, 'data' => $data] = $dataFile;
    switch ($extension) {
        case 'yml':
        case 'yaml':
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        case 'json':
            return json_decode($data);
        default:
            throw new \Exception("Extension {$extension} not supported!");
    }
}
