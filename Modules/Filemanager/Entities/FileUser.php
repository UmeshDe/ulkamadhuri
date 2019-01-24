<?php

namespace Modules\Filemanager\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileUser extends Model
{
    use SoftDeletes;

    protected $table = 'filemanager__fileusers';
    public $translatedAttributes = [];
    protected $fillable = [];

    protected $dates = ['deleted_at'];
}
