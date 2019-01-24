<?php

namespace Modules\Reports\Reports;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Process\Entities\Carton;
use PDF;

class DailyPackingReport extends AbstractReport
{

//'product_date'=>[
//'column_name'=>'product_date',
//'display_name'=>'Date',
//'format'=>'date',
//'header_style' =>'color:red',
//'row_style'=>'color:green',
//'force_value'=>'1',
//],

    public $columns = [
        'sr_no'=>[
            'column_name'=>'sr_no',
            'display_name'=>'Sr No',
            'type'=> REPORT_ROWNO_COLUMN
        ],
        'date'=> [
            'column_name'=>'product',
            'display_name'=>'ProductionDate',
            'type'=>REPORT_RELATION_COLUMN,
            'format'=> REPORT_DATE_FORMAT,
            'relation_column' =>'product_date'
        ],
        'carton_date'=> [
            'column_name'=>'carton_date',
            'format'=> REPORT_DATE_FORMAT,
            'display_name'=>'CartonDate',
        ],
        'variety'=> [
            'column_name'=>'product',
            'display_name'=>'Varity',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'variety'
        ],
        'cm'=> [
            'column_name'=>'product.cm',
            'display_name'=>'CM',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'cm'
        ],
        'lot_no'=>[
            'column_name'=>'product',
            'display_name'=>'Lot',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'lot_no'
        ],
        'bag_color'=> [
            'column_name'=>'product',
            'display_name'=>'BagColor',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'bagColor'
        ],
        'production_slab'=>[
            'column_name'=>'product',
            'display_name'=>'Slab',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'product_slab'
        ],
        'loose' => [
            'column_name'=>'product',
            'display_name'=>'Loose',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'loose'
        ],
        'rejection_slab'=> [
            'column_name'=>'product',
            'display_name'=>'Rejected',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'rejected',
            'default_value' => '0'
        ],
        'human_error' => [
            'column_name' => 'product',
            'display_name' => 'Human error-',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'human_error_slab',
        ],
        'human_error_plus' => [
            'column_name' => 'product',
            'display_name' => 'Human error+',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'human_error_plus',
        ],
        'no_of_cartons'=>[
            'display_name'=>'Cartons',
            'column_name' =>'no_of_cartons',
        ],
        'diff_in_kg'=>[
            'column_name'=>'product',
            'display_name'=>'Diff.In.Kg',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'diff_in_kg',
        ],
        'carton_type'=> [
            'column_name'=>'product',
            'display_name'=>'CartonType',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'cartonType',
        ],
        'po_no'=>[
            'column_name'=>'product',
            'display_name'=>'PO',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'po_no',
        ],
        'bc'=>[
            'column_name'=>'product.buyer',
            'display_name'=>'BC',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' => 'buyer_code',
        ],
        'location'=>[
            'column_name'=>'location',
            'display_name'=>'Location',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'location'
        ],
        'Remark'=>[
            'column_name'=>'product',
            'display_name'=>'Remark',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'packing_remark'
        ],
        'packing_done'=>[
            'column_name'=>'product.users',
            'display_name'=>'Done By',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' => 'first_name'
        ],
    ];
    
    public $date;

    public function formatCode($codes){
        return count($codes);
    }

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

            $queryBuilder = Carton::with('product','product.users','product.buyer','product.approval','product.variety','product.bagColor','product.cartonType','product.fm','product.fr','product.d','product.s','product.a','product.c','product.p','product.b','product.m','product.w','product.q','product.sc','product.lc')->whereHas('product' ,function($q){
                $q->where('product_date','>=',$this->startDate )->where('product_date','<=',$this->endDate );
            });


        }
        elseif ($this->reportDate == 1)
        {
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Carton Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Carton From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Carton To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }
            $queryBuilder = Carton::with('product','product.users','product.buyer','product.approval','product.variety','product.bagColor','product.cartonType','product.fm','product.fr','product.d','product.s','product.a','product.c','product.p','product.b','product.m','product.w','product.q','product.sc','product.lc')->whereHas('product' ,function($q){
                $q->where('status','active');
            })->whereDate('carton_date' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('carton_date' ,'<=',$this->endDate->format('Y-m-d'));
        }

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;
        $this->data = $queryBuilder->get()->sortBy('product.lot_no');
        $this->setupDone = true;

    }

}