<?php

namespace MspPack\DDSGenerate\DatabaseUpdate\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use MspPack\DDSGenerate\DatabaseUpdate\Types\Type;

class MacAddrType extends Type
{
    const NAME = 'macaddr';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'macaddr';
    }
}
