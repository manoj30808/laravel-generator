<?php

namespace MspPack\DDSGenerate\DatabaseUpdate\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use MspPack\DDSGenerate\DatabaseUpdate\Types\Type;

class FloatType extends Type
{
    const NAME = 'float';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'float';
    }
}
