<?php

namespace MspPack\DDSGenerate\DatabaseUpdate\Types\Sqlite;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use MspPack\DDSGenerate\DatabaseUpdate\Types\Type;

class RealType extends Type
{
    const NAME = 'real';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'real';
    }
}
