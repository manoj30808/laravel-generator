<?php

namespace MspPack\DDSGenerate\DatabaseUpdate\Types\Common;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use MspPack\DDSGenerate\DatabaseUpdate\Types\Type;

class CharType extends Type
{
    const NAME = 'char';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        $field['length'] = empty($field['length']) ? 1 : $field['length'];

        return "char({$field['length']})";
    }
}
