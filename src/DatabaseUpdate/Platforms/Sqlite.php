<?php

namespace MspPack\DDSGenerate\DatabaseUpdate\Platforms;

use Illuminate\Support\Collection;

abstract class Sqlite extends Platform
{
    public static function getTypes(Collection $typeMapping)
    {
        $typeMapping->forget([
            'decimal',
            'double',
        ]);

        return $typeMapping->unique();
    }

    public static function registerCustomTypeOptions()
    {
    }
}
