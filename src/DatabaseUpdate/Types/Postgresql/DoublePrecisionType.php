<?php

namespace MspPack\DDSGenerate\DatabaseUpdate\Types\Postgresql;

use MspPack\DDSGenerate\DatabaseUpdate\Types\Common\DoubleType;

class DoublePrecisionType extends DoubleType
{
    const NAME = 'double precision';
    const DBTYPE = 'float8';
}
