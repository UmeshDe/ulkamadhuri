<?php

namespace Modules\Filemanager\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $table = 'filemanager__files';
    public $translatedAttributes = [];
    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];
}
