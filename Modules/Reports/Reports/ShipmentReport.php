<?php
namespace Modules\Reports\Reports;


use Modules\Process\Entities\Shipment;
use Modules\Process\Entities\ShipmentCarton;
use Carbon\Carbon;
use PDF;

class ShipmentReport extends AbstractReport
{
    public $columns = [
        'sr_no'=>[
            'column_name'=>'sr_no',
            'display_name'=>'Sr No',
            'type'=> REPORT_ROWNO_COLUMN
        ],
        'shipment_date'=>[
            'column_name'=>'shipment',
            'display_name'=>'Shipment Date',
            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,REPORT_DATE_FORMAT,
            'relation_column' =>'date'
        ],
        'vehicle_no'=>[
            'column_name'=>'shipment',
            'display_name'=>'Vehicle No:',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'vehicle_no'
        ],
        'container_no'=>[
            'column_name'=>'shipment',
            'display_name'=>'Container No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'container_no'
        ],
        'stuffing_place'=> [
            'column_name'=>'shipment',
            'display_name'=>'Stuffing Place',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'location'
        ],
        'start_time'=>[
            'column_name'=>'shipment',
            'display_name'=>'Start Time',
            'format' => REPORT_TIME_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'start_time'
        ],
        'end_time'=> [
            'column_name'=>'shipment',
            'display_name'=>'End Time',
            'format' => REPORT_TIME_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'end_time'
        ],
        'invoice_no'=> [
            'column_name'=>'shipment',
            'display_name'=>'Invoice No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'invoice_no'
        ],
//        'approval_no'=> [
//            'column_name'=>'carton.product.approval',
//            'display_name'=>'Approval No',
//            'type' => REPORT_RELATION_COLUMN,
//            'relation_column' => 'app_number'
//        ],
//        'varity'=> [
//            'column_name'=>'shipment.carton.product',
//            'display_name'=>'Varity',
//            'type' => REPORT_RELATION_COLUMN,
//            'relation_column' =>'id'
//        ],
        'grade'=> [
            'column_name'=>'shipment',
            'display_name'=>'Grade',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'grade'
        ],
//        'total_cartons'=> [
//            'column_name'=>'carton',
//            'display_name'=>'Total Cartons',
//            'type' => REPORT_RELATION_COLUMN,
//            'relation_column' =>'no_of_cartons'
//        ],
        'cartons_loading'=>[
            'column_name'=>'quantity',
            'display_name'=>'Total Cartons',
        ],
        'seal_no'=> [
            'column_name'=>'shipment',
            'display_name'=>'Seal No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'seal_no'
        ],
        'supervisor'=>[
            'column_name'=>'shipment.supervisor',
            'display_name'=>'Supervisor',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'first_name'
        ],
        'eqc'=> [
            'column_name'=>'shipment',
            'display_name'=>'EQC',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'eqc'
        ],
        'photo'=> [
            'column_name'=>'shipment',
            'display_name'=>'Photo',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'photo'
        ],
        'temp'=>[
            'column_name'=>'shipment',
            'display_name'=>'Temp',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'temperature'
        ],
    ];

    public $sum;

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

        $queryBuilder = ShipmentCarton::with('carton','carton.product','shipment','carton.product.approval','carton.product.fishtype')->whereHas('shipment' ,function($q){
            $q->whereDate('date' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('date' ,'<=',$this->endDate->format('Y-m-d'));});
        $this->data = $queryBuilder->get();


        $this->sum = shipmentCarton::with('carton','carton.product','shipment','carton.product.approval','carton.product.fishtype')->whereHas('shipment' ,function($q){
            $q->whereDate('date' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('date' ,'<=',$this->endDate->format('Y-m-d'));})->sum('quantity');

        $this->setupDone = true;

    }
}