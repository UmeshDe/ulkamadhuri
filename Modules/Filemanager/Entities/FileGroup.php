<?php

namespace Modules\Filemanager\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileGroup extends Model
{
    use SoftDeletes;

    protected $table = 'filemanager__filegroups';
    public $translatedAttributes = [];
    protected $fillable = [];
    protected $dates = ['deleted_at'];
}
