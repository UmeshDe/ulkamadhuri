<?php

namespace Modules\Filemanager\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileType extends Model
{
    use SoftDeletes;

    protected $table = 'filemanager__filetypes';
    public $translatedAttributes = [];
    protected $fillable = [];
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];



    public function category()
    {
        return $this->belongsTo(FileTypeCategory::class,'category_id','id');
    }

    public function owner(){
        return $this->belongsTo('Modules\User\Entities\Sentinel\User','created_by','id');
    }
}
