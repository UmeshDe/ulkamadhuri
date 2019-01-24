<?php
namespace Modules\Reports\Reports;


use Modules\Process\Entities\QualityParameter;
use Carbon\Carbon;
use PDF;

class MandWReport extends AbstractReport
{
    public $columns = [
        'sr_no'=>[
            'column_name'=>'sr_no',
            'display_name'=>'Sr No',
            'type'=> REPORT_ROWNO_COLUMN
        ],
        'product_date'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Product Date',
            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'product_date'
        ],
        'carton_date'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Carton Date',
            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'carton_date'
        ],
        'inspection_date'=>[
            'column_name'=>'inspection_date',
            'display_name'=>'Inspection Date',
            'format' => REPORT_DATE_FORMAT,
        ],
        'kind'=> [
            'column_name'=>'carton.product',
            'display_name'=>'Variety',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'fishtype'
        ],
        'cm'=> [
            'column_name'=>'carton.product.cm',
            'display_name'=>'CM',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'cm'
        ],
        'lot_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Lot No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'machine_moisture'=> [
            'column_name'=>'machine_moisture',
            'display_name'=>'Machine',
        ],
        'supervisor_moisture'=> [
            'column_name'=>'moisture',
            'display_name'=>'Supervisor',
        ],
        'machine_kamaboko_hw'=> [
            'column_name'=>'machine_kamaboko_hw',
            'display_name'=>'Machine',
        ],
        'kamaboko_hw'=> [
            'column_name'=>'kamaboko_hw',
            'display_name'=>'Supervisor',
        ],
        'remark'=> [
            'column_name'=>'carton.product',
            'display_name'=>'Quality Remark',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'remark'
        ],
    ];
    
    public $date;
    
    
    public function setup(){

        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;


        if($this->reportDate == 0)
        {
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Production Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Production From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Production To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }
            $queryBuilder = QualityParameter::with('carton','carton.product','user')->whereHas('carton.product' ,function($q) {
                $q->whereDate('product_date', '>=', $this->startDate)->whereDate('product_date', '<=', $this->endDate);
            });
        }
        else if($this->reportDate == 1)
        {
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Carton Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Carton From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Carton To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }
            $queryBuilder = QualityParameter::with('carton','carton.product','user')->whereHas('carton.product' ,function($q) {
                $q->whereDate('carton_date', '>=', $this->startDate)->whereDate('carton_date', '<=', $this->endDate);
            });
        }
        else if($this->reportDate == 2)
        {
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Inspection Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Inspection From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Inspection To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }
            $queryBuilder = QualityParameter::with('carton','carton.product','user')->whereDate('inspection_date' , '>=' , $this->startDate)->whereDate('inspection_date' ,'<=',$this->endDate);
        }
        else
        {

        }

        $this->data = $queryBuilder->get();

        $this->setupDone = true;

    }
}