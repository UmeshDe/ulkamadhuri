<?php
namespace Modules\Reports\Reports;


use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\InternalcodeRepository;
use Modules\Process\Entities\QualityParameter;
use Carbon\Carbon;
use PDF;

class SurimiQualityReport extends AbstractReport
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
            'type' => REPORT_RELATION_COLUMN,
            'format' => REPORT_DATE_FORMAT,
            'relation_column' => 'product_date'
        ],
        'carton_date'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Carton Date',
            'type' => REPORT_RELATION_COLUMN,
            'format' => REPORT_DATE_FORMAT,
            'relation_column' => 'carton_date'
        ],
        'inspection_date'=>[
            'column_name'=>'inspection_date',
            'format' => REPORT_DATE_FORMAT,
            'display_name'=>'Inspection Date',
        ],
        'approval_no'=>[
            'column_name'=>'carton.product.approval',
            'display_name'=>'EIA',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'app_number'
        ],
        'variety'=> [
            'column_name'=>'carton.product',
            'display_name'=>'Variety',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'fishtype'
        ],
        'cm'=> [
            'column_name'=>'carton.product.cm',
            'display_name'=>'CM',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'cm'
        ],
        'lot_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Lot',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'qcr_pagrno'=>[
            'column_name'=>'qcr_pageno',
            'display_name'=>'QCR Page',
        ],
        'no_of_cartons'=>[
            'column_name'=>'carton',
            'display_name'=>'Cartons',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'no_of_cartons'
        ],
        'grade'=>[
            'column_name'=>'grades',
            'display_name'=>'Grade',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'grade'
        ],
        'ic'=> [
            'column_name'=> 'ic',
            'display_name'=>'IC',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'internal_code'
        ],
        'moisture'=> [
            'column_name'=>'moisture',
            'display_name'=>'Moisture',
        ],
        'standar_wf'=> [
            'column_name'=>'work_force',
            'display_name'=>'W',
        ],
        'standard_l'=>[
            'column_name'=>'length',
            'display_name'=>'L',
        ],
        'standard_gl'=> [
            'column_name'=>'gel_strength',
            'display_name'=>'JS',
        ],
        'suwari_wf'=>[
            'column_name'=>'suwari_work_force',
            'display_name'=>'20%W',
        ],
        'suwari_l'=> [
            'column_name'=>'suwari_length',
            'display_name'=>'20%L',
        ],
        'suwari_gl'=>[
            'column_name'=>'gel_strength',
            'display_name'=>'20%JS',
        ],
        'kamaboko_hw'=> [
            'column_name'=>'kamaboko_hw',
            'display_name'=>'Kamaboko HW',
        ],
        'contam'=> [
            'column_name'=>'contam',
            'display_name'=>'Contam',
        ],
        'ph'=> [
            'column_name'=>'ph',
            'display_name'=>'PH',
        ],
        'bc'=>[
            'column_name'=>'carton.product.buyer',
            'display_name'=>'BC',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'buyer_code'
        ],
    ];
    public $date;
    public $final;

    public function setup(){


        $this->reportMaster->sub_title_style = 'text-align:left';
        

        if($this->reportDate == 0)
        {
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Production Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Production From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Production To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }
            $queryBuilder = QualityParameter::with('carton','ic','carton.product','carton.product.approval','carton.product.fishtype','carton.product.buyer','user')->whereHas('carton.product' ,function($q){
                $q->whereDate('product_date' , '>=' , $this->startDate)->whereDate('product_date' ,'<=',$this->endDate);});

            $this->final = DB::table("process__qualityparameters")
                ->join('process__cartons','process__cartons.id','=','process__qualityparameters.carton_id')
                ->join('process__products','process__cartons.product_id','=','process__products.id')
                ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'))
                ->whereDate('process__products.product_date' , '>=' , $this->startDate)->whereDate('process__products.product_date' ,'<=',$this->endDate)
                ->get();
        }
        else if($this->reportDate == 1){
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Carton Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Carton From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Carton To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }
            $queryBuilder = QualityParameter::with('carton','ic','carton.product','carton.product.approval','carton.product.fishtype','carton.product.buyer','user')->whereHas('carton.product' ,function($q){
                $q->whereDate('carton_date' , '>=' , $this->startDate)->whereDate('carton_date' ,'<=',$this->endDate);});

            $this->final = DB::table("process__qualityparameters")
                ->join('process__cartons','process__cartons.id','=','process__qualityparameters.carton_id')
                ->join('process__products','process__cartons.product_id','=','process__products.id')
                ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'))
                ->whereDate('process__products.carton_date' , '>=' , $this->startDate)->whereDate('process__products.carton_date' ,'<=',$this->endDate)
                ->get();

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
            $queryBuilder = QualityParameter::with('carton','ic','carton.product','carton.product.approval','carton.product.fishtype','carton.product.buyer','user')->whereDate('inspection_date' , '>=' , $this->startDate)->whereDate('inspection_date' ,'<=',$this->endDate);

            $this->final = DB::table("process__qualityparameters")
                ->join('process__cartons','process__cartons.id','=','process__qualityparameters.carton_id')
                ->join('process__products','process__cartons.product_id','=','process__products.id')
                ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'))
                ->whereDate('process__qualityparameters.inspection_date' , '>=' , $this->startDate)->whereDate('process__qualityparameters.inspection_date' ,'<=',$this->endDate)
                ->get();

        }

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;
        $this->reportMaster->subfooter = $this->final;

        $this->data = $queryBuilder->get();

        $this->setupDone = true;

    }
}