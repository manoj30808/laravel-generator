<?php

namespace MspPack\DDSGenerate\DatabaseUpdate\Types\Postgresql;

use MspPack\DDSGenerate\DatabaseUpdate\Types\Common\VarCharType;

class CharacterVaryingType extends VarCharType
{
    const NAME = 'character varying';
    const DBTYPE = 'varchar';
}
