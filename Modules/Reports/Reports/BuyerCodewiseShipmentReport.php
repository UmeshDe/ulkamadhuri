<?php
namespace Modules\Reports\Reports;


use Modules\Admin\Repositories\BuyercodeRepository;
use Modules\Process\Entities\Shipment;
use Modules\Process\Entities\ShipmentCarton;
use Carbon\Carbon;
use PDF;

class BuyerCodewiseShipmentReport extends AbstractReport
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
        'app_no'=> [
            'column_name'=>'carton.product.approval',
            'display_name'=>'EIA No.',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'app_number'
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
        'total_cartons'=> [
            'column_name'=>'carton',
            'display_name'=>'Total Cartons',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'no_of_cartons'
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
        'fm' => [
            'column_name'=>'carton.product',
            'display_name'=>'FM',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'fm'
        ],
        'fr' => [
            'column_name'=>'carton.product',
            'display_name'=>'FR',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'fr'
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
//        'suwari_wf'=>[
//            'column_name'=>'carton.qualitycheck',
//            'display_name'=>'20%W',
//            'type' => REPORT_RELATION_COLUMN,
//            'relation_column' =>'suwari_work_force'
//        ],
//        'suwari_l'=> [
//            'column_name'=>'carton.qualitycheck',
//            'display_name'=>'20%L',
//            'type' => REPORT_RELATION_COLUMN,
//            'relation_column' =>'suwari_length'
//        ],
//        'suwari_gl'=>[
//            'column_name'=>'carton.qualitycheck',
//            'display_name'=>'20%JS',
//            'type' => REPORT_RELATION_COLUMN,
//            'relation_column' =>'gel_strength'
//        ],
        'moisture'=> [
            'column_name'=>'carton.qualitycheck',
            'display_name'=>'Moisture',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'moisture'
        ],
        'grade'=>[
            'column_name'=>'carton.qualitycheck.grades',
            'display_name'=>'Grade',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'grade'
        ],
        'ic'=>[
            'column_name'=>'carton.qualitycheck.ic',
            'display_name'=>'IC',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'internal_code'
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

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;
        
        $buyer = app(BuyercodeRepository::class)->find($this->buyer);
        
        if($this->container != null || $this->container != "")
        {
            $this->containerno = $this->container;
            foreach ($this->buyer as $buyer)
            {
                $this->buyercode [] = app(BuyercodeRepository::class)->find($buyer);
            }

//            $this->reportMaster->sub_title = 'Container No :'.$this->container;
            $queryBuilder = ShipmentCarton::with('carton','carton.product','carton.product.fishtype','shipment')->whereHas('shipment' ,function($q){
                $q->whereIn('container_no', $this->container );
            })->whereHas('carton.product' ,function($q){
                $q->whereIn('buyercode_id', $this->buyer );})->whereHas('carton.product' ,function ($query) {
                $query->orderBy('po_no');
            });
        }

        

        $this->data = $queryBuilder->get();

        $this->setupDone = true;

    }
}