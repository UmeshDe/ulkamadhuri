<?php
namespace Modules\Reports\Reports;

use Modules\Process\Entities\Repack;
use Carbon\Carbon;
use PDF;

class RepackingReport extends AbstractReport
{
    public $columns = [
        'sr_no'=>[
            'column_name'=>'sr_no',
            'display_name'=>'Sr No',
            'type'=> REPORT_ROWNO_COLUMN
        ],
        'production_date' => [
            'column_name' => 'carton.product',
            'display_name' => 'Production Date',
            'format' => REPORT_DATE_FORMAT,
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'product_date'
         ],
        'carton_date' => [
            'column_name' => 'carton',
            'display_name' => 'Carton Date',
            'format' => REPORT_DATE_FORMAT,
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'carton_date'
        ],
        'variety' => [
            'column_name' => 'carton.product',
            'display_name' => 'Variety',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'fishtype'
        ],
        'cm' => [
            'column_name' => 'carton.product.cm',
            'display_name' => 'CM',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'cm'
        ],
        'grade' => [
            'column_name' => 'carton.qualitycheck.grades',
            'display_name' => 'Old Grade',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'grade'
        ],
        'lot_no'=> [
            'column_name'=> 'carton.product',
            'display_name'=>'Lot No',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'lot_no'
        ],
        'bag_color'=> [
            'column_name'=>'carton.bagColor',
            'display_name'=>'Bag Color',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'color'
        ],
        'no_of_cartons'=> [
            'column_name'=>'carton',
            'display_name'=>'No.Of.Cartons',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'no_of_cartons'
        ],
        'repacked_spp' => [
            'column_name'=>'fishtype',
            'display_name'=>'Repacke SPP',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'type'
        ],
        'repacked_date' => [
            'column_name'=>'repacked_date',
            'format' => REPORT_DATE_FORMAT,
            'display_name'=>'Repacke Date',
        ],
        'repacked_lotno' => [
            'column_name'=>'lot_no',
            'display_name'=>'Repacke Lot No',
        ],
        'repacked_bagcolor' => [
            'column_name'=>'bagcolor',
            'display_name'=>'Repacke Bag Color',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'color'
        ],
        'repacked_cartons' => [
            'column_name'=>'repacked_cartons',
            'display_name'=>'Repacke Cartons',
        ],
        'repacked_grade' => [
            'column_name'=>'grade',
            'display_name'=>'Repacke Grade',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'grade'
        ],
        'remark' => [
            'column_name'=>'remark',
            'display_name'=>'Remark',
        ],
        'repackingdone_by' => [
            'column_name'=>'repack',
            'display_name'=>'Repacking Done By',
            'type'=> REPORT_RELATION_COLUMN,
            'relation_column' =>'first_name'
        ],
    ];
    
    public $date;
    
    
    public function setup(){

        if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
        {
            $this->date = 'Repacking Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
        }
        else{
            $this->date = 'Repacking From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Repacking To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
        }

        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;

        $queryBuilder = Repack::with('carton','carton.product','carton.qualitycheck.grades','carton.bagColor')->whereDate('repack_date' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('repack_date' ,'<=',$this->endDate->format('Y-m-d'));
        $this->data = $queryBuilder->get();

        $this->setupDone = true;

    }
}