<?php

namespace Modules\Filemanager\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileTypeCategory extends Model
{
   
    use SoftDeletes;
    protected $table = 'filemanager__filetypecategories';
    public $translatedAttributes = [];
    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function owner(){
        return $this->belongsTo('Modules\User\Entities\Sentinel\User','created_by','id');
    }
}
