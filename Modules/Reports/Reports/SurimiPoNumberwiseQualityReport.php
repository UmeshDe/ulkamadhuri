<?php
namespace Modules\Reports\Reports;


use Modules\Process\Entities\QualityParameter;
use Carbon\Carbon;
use Modules\Process\Entities\ShipmentCarton;
use Modules\Process\Repositories\ProductRepository;
use PDF;

class SurimiPoNumberwiseQualityReport extends AbstractReport
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
            'format'=> REPORT_DATE_FORMAT,
            'relation_column' => 'product_date'
        ],
        'carton_date'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Carton Date',
            'type' => REPORT_RELATION_COLUMN,
            'format'=> REPORT_DATE_FORMAT,
            'relation_column' => 'carton_date'
        ],
        'inspection_date'=>[
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'Inspection Date',
            'type' => REPORT_RELATION_COLUMN,
            'format'=> REPORT_DATE_FORMAT,
            'relation_column' => 'inspection_date'
        ],
        'variety'=> [
            'column_name'=>'carton.product.fishtype',
            'display_name'=>'Variety',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'type'
        ],
        'cm'=> [
            'column_name'=>'carton.product.cm',
            'display_name'=>'CM',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'cm'
        ],
        'lot_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Lot No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'qcr_pageno'=>[
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'QCR Page',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'qcr_pageno'
        ],
        'no_of_cartons'=>[
            'column_name'=>'carton.product',
            'display_name'=>'No.Of.Cartons',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'no_of_cartons'
        ],
        'grade'=>[
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'Grade',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'grades'
        ],
        'ic'=>[
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'IC',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'ic'
        ],
        'moisture'=> [
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'Moisture',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'moisture'
        ],
        'standar_wf'=> [
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'W',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'work_force'
        ],
        'standard_l'=>[
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'L',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'length'
        ],
        'standard_gl'=> [
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'JS',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'gel_strength'
        ],
        'suwari_wf'=>[
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'20%W',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'suwari_work_force'
        ],
        'suwari_l'=> [
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'20%L',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'suwari_length'
        ],
        'suwari_gl'=>[
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'20%JS',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'gel_strength'
        ],
        'kamaboko_hw'=> [
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'Kamaboko HW',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'kamaboko_hw'
        ],
        'contam'=> [
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'Contam',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'contam'
        ],
        'ph'=> [
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'PH',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'ph'
        ],
        'shipped_qty'=>[
            'column_name'=>'quantity',
            'display_name'=>'Shipped QTY',
        ],
        'po_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'PO No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'po_no'
        ],
        'container_no'=>[
            'column_name'=>'shipment',
            'display_name'=>'Container No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'container_no'
        ],
    ];
    public $code;
    public $containerno;
    public $buyercode;

    public function setup(){


        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->reportMaster->title = "PO NUMBERWISE QUALITY REPORT";

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;

        if($this->containerno != null || $this->containerno != "")
        {
            $queryBuilder = ShipmentCarton::with('carton','carton.product','shipment','carton.product.approval','carton.product.fishtype','location')->whereHas('shipment' ,function($q){
                $q->where('container_no' , '=' , $this->containerno);});
        }

        $this->data = $queryBuilder->get();

        $this->setupDone = true;

    }
}