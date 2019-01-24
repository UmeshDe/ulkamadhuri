<?php
namespace Modules\Reports\Reports;


use Illuminate\Support\Facades\DB;
use Modules\Process\Entities\Shipment;
use Modules\Process\Entities\ShipmentCarton;
use Carbon\Carbon;
use Modules\Process\Repositories\ShipmentRepository;
use PDF;

class NewCodeListReport extends AbstractReport
{
    public $columns = [
        'sr_no'=>[
            'column_name'=>'sr_no',
            'display_name'=>'Sr No',
            'type'=> REPORT_ROWNO_COLUMN
        ],
//        'approval_no'=> [
//            'column_name'=>'carton.product.approval',
//            'display_name'=>'Approval No',
//            'type' => REPORT_RELATION_COLUMN,
//            'relation_column' => 'app_number'
//        ],
        'varity'=> [
            'column_name'=>'carton.product.fishtype',
            'display_name'=>'Varity',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'type'
        ],
        'carton_date'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Carton Date',
            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,REPORT_DATE_FORMAT,
            'relation_column' =>'carton_date'
        ],
        'lot_no'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Lot No',
//            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'lot_no'
        ],
        'place'=>[
            'column_name'=>'location',
            'display_name'=>'Place',
//            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'location'
        ],
        'grade'=> [
            'column_name'=>'grademark',
            'display_name'=>'Grade Mark',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' =>'grademark'
        ],
        'thappy'=> [
            'column_name'=>'thappy',
            'display_name'=>'Thappy',
        ],
        'photo_from'=> [
            'column_name'=>'from',
            'display_name'=>'Photo From',
        ],
        'photo_to'=> [
            'column_name'=>'to',
            'display_name'=>'Photo To',
        ],
        'total_cartons'=> [
            'column_name'=>'quantity',
            'display_name'=>'Total',
        ],

    ];

    public $shipment;
    public $sum;


    public function setup(){


        $this->shipment = app(ShipmentRepository::class)->findByAttributes(['container_no' => $this->containerno]);


        $this->reportMaster->title = "CONTAINER CODE LIST ";

        if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
        {
            $this->reportMaster->sub_title = 'Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
        }
        else{
            $this->reportMaster->sub_title = 'From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
        }

        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;

        $queryBuilder = ShipmentCarton::with('carton','carton.product','shipment','carton.product.approval','carton.product.fishtype','location')->whereHas('shipment' ,function($q){
            $q->where('container_no' , '=' , $this->containerno);});

        $this->sum =  DB::table("process__shipmentcartons")
            ->join('process__shipments','process__shipments.id','=','process__shipmentcartons.shipment_id')
            ->select(DB::raw('SUM(process__shipmentcartons.quantity) as total'))
            ->where('process__shipments.container_no',$this->containerno)
            ->get();

        $this->data = $queryBuilder->get();

        $this->setupDone = true;

    }
}