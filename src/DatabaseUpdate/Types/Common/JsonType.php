<?php

namespace MspPack\DDSGenerate\DatabaseUpdate\Types\Common;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use MspPack\DDSGenerate\DatabaseUpdate\Types\Type;

class JsonType extends Type
{
    const NAME = 'json';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'json';
    }
}
