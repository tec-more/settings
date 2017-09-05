<?php namespace Tukecx\Base\Settings\Models;

use Tukecx\Base\Core\Models\EloquentBase as BaseModel;

class EloquentSetting extends BaseModel
{
    protected $table = 'settings';

    protected $primaryKey = 'id';
}
