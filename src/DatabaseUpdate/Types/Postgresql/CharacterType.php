<?php

namespace MspPack\DDSGenerate\DatabaseUpdate\Types\Postgresql;

use MspPack\DDSGenerate\DatabaseUpdate\Types\Common\CharType;

class CharacterType extends CharType
{
    const NAME = 'character';
    const DBTYPE = 'bpchar';
}
