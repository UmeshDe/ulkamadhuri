<?php
namespace Modules\Reports\Reports;


use Modules\Process\Entities\QualityParameter;
use Carbon\Carbon;
use PDF;

class QualityCheckReport extends AbstractReport
{
    public $columns = [
        'sr_no'=>[
            'column_name'=>'sr_no',
            'display_name'=>'Sr No',
            'type'=> REPORT_ROWNO_COLUMN
        ],
        'inspection_date'=>[
            'column_name'=>'inspection_date',
            'display_name'=>'Inspection Date',
        ],
        'product_date'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Product Date',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'product_date'
        ],
        'lot_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Lot No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'kind'=> [
            'column_name'=>'kinds',
            'display_name'=>'Variety',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'kind'
        ],
        'grade'=>[
            'column_name'=>'grades',
            'display_name'=>'Grade',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'grade'
        ],
        'moisture'=> [
            'column_name'=>'moisture',
            'display_name'=>'Moisture',
        ],
        'kamaboko_hw'=> [
            'column_name'=>'kamaboko_hw',
            'display_name'=>'Kamaboko HW',
        ],
        'ashi'=> [
            'column_name'=>'ashi',
            'display_name'=>'Ashi',
        ],
        'contam'=> [
            'column_name'=>'contam',
            'display_name'=>'Contam',
        ],
        'ph'=> [
            'column_name'=>'ph',
            'display_name'=>'PH',
        ],
        'standar_wf'=> [
            'column_name'=>'work_force',
            'display_name'=>'Work Force',
        ],
        'standard_l'=>[
            'column_name'=>'length',
            'display_name'=>'Length',
        ],
        'standard_gl'=> [
            'column_name'=>'gel_strength',
            'display_name'=>'Gel Strength',
        ],
        'suwari_wf'=>[
            'column_name'=>'suwari_work_force',
            'display_name'=>'20% Work Force',
        ],
        'suwari_l'=> [
            'column_name'=>'suwari_length',
            'display_name'=>'20% Length',
        ],
        'suwari_gl'=>[
            'column_name'=>'gel_strength',
            'display_name'=>'20% Gel Strength',
        ],
    ];


    public function setup(){

        if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
        {
            $this->reportMaster->sub_title = 'Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
        }
        else{
            $this->reportMaster->sub_title = 'From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
        }

        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;

        $queryBuilder = QualityParameter::with('carton','carton.product','user')->whereDate('created_at' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('created_at' ,'<=',$this->endDate->format('Y-m-d'));

        $this->data = $queryBuilder->get();

        $this->setupDone = true;

    }
}