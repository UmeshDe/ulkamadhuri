<?php
namespace Modules\Reports\Reports;


use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\InternalcodeRepository;
use Modules\Process\Entities\QualityParameter;
use Carbon\Carbon;
use Modules\Process\Repositories\ProductRepository;
use PDF;

class PoNumberwiseQualityDataReport extends AbstractReport
{
    public $columns = [
        'sr_no'=>[
            'column_name'=>'sr_no',
            'display_name'=>'Sr No',
            'type'=> REPORT_ROWNO_COLUMN
        ],
        'product_date'=>[
            'column_name'=>'carton.product',
            'display_name'=>'PD',
            'type' => REPORT_RELATION_COLUMN,
            'format' => REPORT_DATE_FORMAT,
            'relation_column' => 'product_date'
        ],
        'carton_date'=>[
            'column_name'=>'carton.product',
            'display_name'=>'CD',
            'type' => REPORT_RELATION_COLUMN,
            'format' => REPORT_DATE_FORMAT,
            'relation_column' => 'carton_date'
        ],
        'variety'=> [
            'column_name'=>'carton.product',
            'display_name'=>'Variety',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'variety'
        ],
        'lot_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Lot No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'no_of_cartons'=>[
            'column_name'=>'carton',
            'display_name'=>'Cartons',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'no_of_cartons'
        ],
        'no_of_slab'=>[
            'column_name'=>'carton.product',
            'display_name'=>'No. Slab',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'product_slab'
        ],
        'bag_color'=> [
            'column_name'=>'carton.product',
            'display_name'=>'Bag Color',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'bagColor'
        ],
//        'cm'=> [
//            'column_name'=>'carton.product.cm',
//            'display_name'=>'CM',
//            'type' => REPORT_RELATION_COLUMN,
//            'relation_column' =>'cm'
//        ],



//        'po_no'=> [
//            'column_name'=>'carton.product',
//            'display_name'=>'PO No',
//            'type' => REPORT_RELATION_COLUMN,
//            'relation_column' => 'po_no'
//        ],
        'fm' => [
            'column_name'=>'carton.product',
            'display_name'=>'FM',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'fm'
        ],
        'i' => [
            'column_name'=>'carton.product',
            'display_name'=>'I',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'i'
        ],
        'k' => [
            'column_name'=>'carton.product',
            'display_name'=>'K',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'k'
        ],
        'e' => [
            'column_name'=>'carton.product',
            'display_name'=>'E',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'e'
        ],
        't' => [
            'column_name'=>'carton.product',
            'display_name'=>'T',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'t'
        ],
        'sg' => [
            'column_name'=>'carton.product',
            'display_name'=>'SG',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'sg'
        ],
        'kg' => [
            'column_name'=>'carton.product',
            'display_name'=>'KG',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'kg'
        ],
        'g' => [
            'column_name'=>'carton.product',
            'display_name'=>'G',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'g'
        ],
        'h' => [
            'column_name'=>'carton.product',
            'display_name'=>'H',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'h'
        ],
        'rc' => [
            'column_name'=>'carton.product',
            'display_name'=>'RC',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'rc'
        ],
        'mk' => [
            'column_name'=>'carton.product',
            'display_name'=>'MK',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'mk'
        ],
        'kt' => [
            'column_name'=>'carton.product',
            'display_name'=>'KT',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'fr'
        ],
        'v' => [
            'column_name'=>'carton.product',
            'display_name'=>'V',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'v'
        ],
        'd' => [
            'column_name'=>'carton.product',
            'display_name'=>'D',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'d'
        ],
        's' => [
            'column_name'=>'carton.product',
            'display_name'=>'S',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'s'
        ],
        'a' => [
            'column_name'=>'carton.product',
            'display_name'=>'A',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'a'
        ],
        'c' => [
            'column_name'=>'carton.product',
            'display_name'=>'C',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'c'
        ],
        'p' => [
            'column_name'=>'carton.product',
            'display_name'=>'P',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'p'
        ],
        'b' => [
            'column_name'=>'carton.product',
            'display_name'=>'B',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'b'
        ],
        'm' => [
            'column_name'=>'carton.product',
            'display_name'=>'M',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'m'
        ],
        'w' => [
            'column_name'=>'carton.product',
            'display_name'=>'W',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'w'
        ],
        'q' => [
            'column_name'=>'carton.product',
            'display_name'=>'Q',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'q'
        ],
        'sc' => [
            'column_name'=>'carton.product',
            'display_name'=>'SC',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'sc'
        ],
        'lc' => [
            'column_name'=>'carton.product',
            'display_name'=>'LC',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'lc'
        ],
        'qcr_pagrno'=>[
            'column_name'=>'qcr_pageno',
            'display_name'=>'QCR Page',
        ],
        'inspection_date'=>[
            'column_name'=>'inspection_date',
            'format' => REPORT_DATE_FORMAT,
            'display_name'=>'Inspection Date',
        ],
        'grade'=>[
            'column_name'=>'grades',
            'display_name'=>'Grade',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'grade'
        ],
        'ic'=>[
            'column_name'=>'ic',
            'display_name'=>'IC',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'internal_code'
        ],
        'moisture'=> [
            'column_name'=>'moisture',
            'display_name'=>'Supervisor Moisture',
        ],
        'machine_moisture'=> [
            'column_name'=>'machine_moisture',
            'display_name'=>'Machine Moisture',
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
            'display_name'=>'20% W',
        ],
        'suwari_l'=> [
            'column_name'=>'suwari_length',
            'display_name'=>'20% L',
        ],
        'suwari_gl'=>[
            'column_name'=>'gel_strength',
            'display_name'=>'20% JS',
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
    ];


    public function formatCode($codes){
        return count($codes);
    }

    public $date;
    public $sum;

    public function setup(){

        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->reportMaster->footer = 'Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name ;


        $this->reportMaster->subfooter = $this->sum;

        if($this->reportDate == 0)
        {
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Production Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Production From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Production To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }
            $this->sum =   $this->total = DB::table("process__qualityparameters")
                ->join('process__cartons','process__cartons.id','=','process__qualityparameters.carton_id')
                ->join('process__products','process__cartons.product_id','=','process__products.id')
                ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'))
                ->whereDate('process__products.product_date' , '>=' , $this->startDate)->whereDate('process__products.product_date' ,'<=',$this->endDate)
                ->get();

            $this->reportMaster->subfooter = $this->sum;

            $queryBuilder = QualityParameter::with('carton','ic','carton.product','carton.product.codes','user')->whereHas('carton.product' ,function($q){
                $q->whereDate('product_date' , '>=' , $this->startDate)->whereDate('product_date' ,'<=',$this->endDate);});
        }
        else if($this->reportDate == 1){
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Carton Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Carton From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Carton To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }
            $this->sum =   $this->total = DB::table("process__qualityparameters")
                ->join('process__cartons','process__cartons.id','=','process__qualityparameters.carton_id')
                ->join('process__products','process__cartons.product_id','=','process__products.id')
                ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'))
                ->whereDate('process__products.carton_date' , '>=' , $this->startDate)->whereDate('process__products.carton_date' ,'<=',$this->endDate)
                ->get();
            $this->reportMaster->subfooter = $this->sum;

            $queryBuilder = QualityParameter::with('carton','ic','carton.product','carton.product.codes','user')->whereHas('carton.product' ,function($q){
                $q->whereDate('carton_date' , '>=' , $this->startDate)->whereDate('carton_date' ,'<=',$this->endDate);});
        }
        else if($this->reportDate == 2){
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Inspection  Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Inspection From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Inspection To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }
            $this->sum =   $this->total = DB::table("process__qualityparameters")
                ->join('process__cartons','process__cartons.id','=','process__qualityparameters.carton_id')
                ->join('process__products','process__cartons.product_id','=','process__products.id')
                ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'))
                ->whereDate('process__qualityparameters.inspection_date' , '>=' , $this->startDate)->whereDate('process__qualityparameters.inspection_date' ,'<=',$this->endDate)
                ->get();
            $this->reportMaster->subfooter = $this->sum;


            $queryBuilder = QualityParameter::with('carton','ic','carton.product','carton.product.codes','user')->whereDate('inspection_date' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('inspection_date' ,'<=',$this->endDate->format('Y-m-d'));
        }
        else
        {
            $queryBuilder = QualityParameter::with('carton','ic','carton.product','carton.product.codes','user')->whereDate('inspection_date' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('inspection_date' ,'<=',$this->endDate->format('Y-m-d'));
        }

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;

        $this->data = $queryBuilder->orderby('carton_id')->get();


        $this->setupDone = true;

    }
}
