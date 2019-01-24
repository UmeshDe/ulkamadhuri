<?php

namespace Modules\Reports\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ReportMaster extends Model
{

    protected $table = 'reports__reportmasters';
    public $translatedAttributes = [];
    protected $fillable = [
        'name',
        'module_id',
        'query',
        'orientation',
        'papersize',
        'type',
        'class',
        'template_file_id',
        'frequency',
        'is_mnth_gnrtn',
        'export_formats',
        'code',
        'title',
        'sub_title',
        'sub_footer',
        'sub_title_style',
        'footer',
        'title_style',
        'sub_footer_style',
        'footer_style',
        'viewname'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo(ReportModule::class,'module_id','id');
    }
}
