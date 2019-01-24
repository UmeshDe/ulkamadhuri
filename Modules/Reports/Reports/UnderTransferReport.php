<?php
/**
 * Created by PhpStorm.
 * User: accunity
 * Date: 11/10/17
 * Time: 7:13 PM
 */

namespace Modules\Reports\Reports;

use Modules\Process\Entities\CartonLocation;
use Carbon\Carbon;
use Modules\Process\Entities\TransferCarton;
use PDF;

class UnderTransferReport extends AbstractReport
{
    public $columns = [
        'sr_no'=>[
            'column_name'=>'sr_no',
            'display_name'=>'Sr No',
            'type'=> REPORT_ROWNO_COLUMN
        ],
        'location_id' => [
            'column_name'=>'transfer.loadinglocation',
            'display_name'=>'Loading Location',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'location'
        ],
        'product_date'=> [
            'column_name'=>'carton.product',
            'display_name'=>'Product Date',
            'type' => REPORT_RELATION_COLUMN,
            'format' => REPORT_DATE_FORMAT,
            'relation_column' => 'product_date'
        ],
        'carton_date'=>[
            'column_name'=>'carton',
            'display_name'=>'Carton Date',
            'type' => REPORT_RELATION_COLUMN,
            'format' => REPORT_DATE_FORMAT,
            'relation_column' =>'carton_date'
        ],
        'lot_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Lot No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
//        'available_quantity'=>[
//            'column_name'=>'available_quantity',
//            'display_name'=>'Available Quantity',
//        ],
        'transit'=>[
            'column_name'=>'quantity',
            'display_name'=>'No.Of.Cartons In Transit',

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

        if($this->vehicle != null || $this->vehicle != "")
        {
            $queryBuilder = TransferCarton::with('transfer','transfer.loadinglocation','carton.product')->whereHas('transfer' ,function($q) {
                $q->whereIn('vehicle_no',$this->vehicle);
                $q->whereIn('container_no',$this->container);
            })->where('received_quantity',0);
        }
//        else{
//            $this->reportMaster->sub_title = 'Container No: ' . $this->container ;
//            $queryBuilder = TransferCarton::with('transfer','transfer.loadinglocation','carton.product')->whereHas('transfer' ,function($q) {
//
//            });
//        }

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;

        $this->data = $queryBuilder->get();

        $this->setupDone = true;

    }

}