<?php namespace MspPack\DDSGenerate;

use Illuminate\Database\Eloquent\Model;

class Generator extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modules';
    protected $guarded = [];
}