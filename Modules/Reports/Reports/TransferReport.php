<?php
/**
 * Created by PhpStorm.
 * User: accunity
 * Date: 11/10/17
 * Time: 7:13 PM
 */

namespace Modules\Reports\Reports;

use Modules\Process\Entities\TransferCarton;
use Carbon\Carbon;
use PDF;

class TransferReport extends AbstractReport
{
    public $columns = [
        'load_gp_no'=> [
            'column_name'=>'transfer',
            'display_name'=>'Load Gate Pass No',
            'type' => REPORT_RELATION_COLUMN,
             'relation_column' =>'loading_gate_pass_no'
        ],
        'carton_date'=>[
            'column_name'=>'carton',
            'display_name'=>'CartonDate',
            'type' => REPORT_RELATION_COLUMN,
            'format' => REPORT_DATE_FORMAT,
            'relation_column' =>'carton_date'
        ],
        'loading_date'=>[
            'column_name'=>'transfer',
            'display_name'=>'LoadDate',
            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'loading_date'
        ],
        'variety'=> [
            'column_name'=>'carton.product.fishtype',
            'display_name'=>'Varity',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'type'
        ],
        'cm'=> [
            'column_name'=>'carton.product.cm',
            'display_name'=>'CM',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'cm'
        ],
        'vehicle_no' => [
            'column_name'=>'transfer',
            'display_name'=>'Vehicle',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'vehicle_no'
        ],
        'lot_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Load Lot No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'bc'=> [
            'column_name'=>'carton.product.buyer',
            'display_name'=>'BC',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'buyer_code'
        ],
        'appr_no'=>[
            'column_name'=>'carton.product.approval',
            'display_name'=>'EIA No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'app_number'
        ],
        'bag_color'=> [
            'column_name'=>'carton.product.bagColor',
            'display_name'=>'Bag Color',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'color'
        ],
        'carton_type'=> [
            'column_name'=>'carton.cartontype',
            'display_name'=>'Carton Type',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'type'
        ],
        'no_of_cartons'=>[
            'column_name'=>'quantity',
            'display_name'=>'Loading No Of Cartons',
        ],
        'loading_start_time'=> [
            'column_name'=>'transfer',
            'display_name'=>'Load Start Time',
            'format' => REPORT_TIME_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'loading_start_time'
        ],
        'loading_end_time'=> [
            'column_name'=>'transfer',
            'display_name'=>'Load End Time',
            'format' => REPORT_TIME_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'loading_end_time'
        ],
        'loading_supervisor'=> [
            'column_name'=>'transfer.loadingsupervisor',
            'display_name'=>'Load Supervisor',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'first_name'
        ],
        'loading_sub_loc'=> [
            'column_name'=>'transfer',
            'display_name'=>'Load Location',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'loadinglocation'
        ],
        'unload_gp_no'=> [
            'column_name'=>'transfer',
            'display_name'=>'Unoad Gate Pass No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'unloading_gate_pass_no'
        ],
        'unloading_date'=>[
            'column_name'=>'transfer',
            'display_name'=>'UnloadDate',
            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'unloading_date'
        ],
        'unloading_lot_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Unload Lot No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'unloading_no_qty'=>[
            'column_name'=>'received_quantity',
            'display_name'=>'Unloading Carton',
        ],
        'unloading_start_time'=> [
            'column_name'=>'transfer',
            'display_name'=>'Unload Start Time',
            'format' => REPORT_TIME_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'unloading_start_time'
        ],
        'unloading_end_time'=> [
            'column_name'=>'transfer',
            'display_name'=>'Unload End Time',
            'format' => REPORT_TIME_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'unloading_end_time'
        ],
        'unloading_supervisor'=> [
            'column_name'=>'transfer.unloadingsupervisor',
            'display_name'=>'Unoad Supervisor',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'first_name'
        ],
        'unloading_sub_loc'=> [
            'column_name'=>'transfer',
            'display_name'=>'Unolad Location',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'unloadinglocation'
        ],
        'remark'=>[
            'column_name'=>'transfer',
            'display_name'=>'Remark',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'unloading_remark'
        ],
    ];

    public $vehicleno;
    public $containerno;

    public function formatCode($product){
        return count($product['product_date']);
    }
    
    public function setup(){

        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->vehicleno = $this->vehicle;
        $this->containerno = $this->container;

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;

        if($this->vehicle != null || $this->vehicle != "")
        {
            $this->reportMaster->sub_title = 'Loading From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Loading To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT);
//                $this->reportMaster->sub_title = 'Vehicle No: ' . $this->vehicle;
                $queryBuilder = TransferCarton::with('transfer','carton','carton.product','carton.product.buyer','carton.cartontype','transfer.loadinglocation','transfer.loadingsupervisor','transfer.unloadinglocation','transfer.unloadingsupervisor','carton.product.fishtype')->whereHas('transfer' ,function($q){
                $q->whereIn('vehicle_no',$this->vehicle);
                $q->whereIn('container_no',$this->container);
                $q->whereDate('loading_date' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('loading_date' ,'<=',$this->endDate->format('Y-m-d'));
                });
        }
//        else if($this->container != null || $this->container != "")
//        {
//            $this->reportMaster->sub_title = 'Container No: ' . $this->container;
//            $queryBuilder = TransferCarton::with('transfer','carton','carton.product','carton.product.buyer','carton.cartontype','transfer.loadinglocation','transfer.loadingsupervisor','transfer.unloadinglocation','transfer.unloadingsupervisor','carton.product.fishtype')->whereHas('transfer' ,function($q){
//
//        }
//        else{
//            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
//            {
//                $this->reportMaster->sub_title = 'Loading Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT);
//            }
//            else{
//                $this->reportMaster->sub_title = 'Loading From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Loading To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT);
//            }
//
//            $queryBuilder = TransferCarton::with('transfer','carton','carton.product','carton.product.buyer','carton.cartontype','transfer.loadinglocation','transfer.loadingsupervisor','transfer.unloadinglocation','transfer.unloadingsupervisor','carton.product.fishtype')->whereHas('transfer' ,function($q){
//
//        }
        $this->data = $queryBuilder->get();
        $this->setupDone = true;

    }

}