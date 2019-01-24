<?php
namespace Modules\Reports\Reports;


use Hamcrest\Text\SubstringMatcher;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\FishTypeRepository;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Process\Entities\CartonLocation;
use Modules\Process\Entities\QualityParameter;
use Carbon\Carbon;
use Modules\Process\Repositories\CartonLocationRepository;
use PDF;

class SurimiProductionQualityStockReport extends AbstractReport
{
    public $columns = [
        'sr_no' => [
            'column_name' => 'sr_no',
            'display_name' => 'Sr No',
            'type' => REPORT_ROWNO_COLUMN
        ],
        'product_date' => [
            'column_name' => 'carton.product',
            'display_name' => 'PD',
            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'product_date'
        ],
        'carton_date' => [
            'column_name' => 'carton.product',
            'display_name' => 'CD',
            'format' => REPORT_DATE_FORMAT,
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'carton_date'
        ],
        'variety' => [
            'column_name' => 'carton.product',
            'display_name' => 'SPP',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'fishtype'
        ],
        'cm' => [
            'column_name' => 'carton.product.cm',
            'display_name' => 'CM',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'cm'
        ],
        'lot_no' => [
            'column_name' => 'carton.product',
            'display_name' => 'Lot No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'no_of_slab' => [
            'column_name' => 'carton.product',
            'display_name' => 'Slab',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'product_slab'
        ],
        'bag_color' => [
            'column_name' => 'carton.product',
            'display_name' => 'Bag Color',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'bagColor'
        ],
        'po_no' => [
            'column_name' => 'carton.product',
            'display_name' => 'PO No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'po_no'
        ],
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
            'column_name' => 'carton.product',
            'display_name' => 'KT',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'fr'
        ],
        'v' => [
            'column_name' => 'carton.product',
            'display_name' => 'V',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'v'
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

        'qcr_pagrno' => [
            'column_name' => 'qcr_pageno',
            'display_name' => 'QCR Page',
        ],
        'inspection_date' => [
            'column_name' => 'inspection_date',
            'format' => REPORT_DATE_FORMAT,
            'display_name' => 'ID',
        ],
        'no_of_cartons' => [
            'column_name' => 'carton.product',
            'display_name' => 'Cart',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'no_of_cartons'
        ],
        'grade' => [
            'column_name' => 'grades',
            'display_name' => 'Grade',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'grade'
        ],
        'ic' => [
            'column_name' => 'ic',
            'display_name' => 'IC',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'internal_code'
        ],
        'moisture' => [
            'column_name' => 'moisture',
            'display_name' => 'Mois.',
        ],
        'standar_wf' => [
            'column_name' => 'work_force',
            'display_name' => 'W',
        ],
        'standard_l' => [
            'column_name' => 'length',
            'display_name' => 'L',
        ],
        'standard_gl' => [
            'column_name' => 'gel_strength',
            'display_name' => 'JS',
        ],
        'kamaboko_hw' => [
            'column_name' => 'kamaboko_hw',
            'display_name' => 'HW',
        ],
        'contam' => [
            'column_name' => 'contam',
            'display_name' => 'Cont',
        ],
        'ph' => [
            'column_name' => 'ph',
            'display_name' => 'PH',
        ],
        'balance_qty' => [
            'column_name' => 'carton.cartonlocation',
            'display_name' => 'Bal Qty',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'available_quantity'
        ],
        'warehouse' => [
            'column_name' => 'carton.location',
            'display_name' => 'Loc',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'location'
        ],
    ];

    public $date;

    public $total;
    public $grades;
    public $fishtypes;

    public function formatCode($codes)
    {
        return count($codes);
    }

    public function setup()
    {

//        dd($this->grade);
//        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->reportMaster->footer = ' Printed by :' . auth()->user()->first_name . " " . auth()->user()->last_name . ' , ' . 'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT);


        if ($this->reportDate !== null) {

            if ($this->grade != null) {
                foreach ($this->grade as $grade) {
                    $this->grades [] = app(GradeRepository::class)->find($grade);
                }
            }


            foreach ($this->variety as $variety) {
                $this->fishtypes [] = app(FishTypeRepository::class)->find($variety);
            }

            $this->date = 'Carton From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '_____Carton To Date:' . Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT);


//            $grade = app(GradeRepository::class)->find($this->grade);
//            $this->date = 'Grade: ' . $grade->grade ;

            if ($this->grade != null) {
                $queryBuilder = QualityParameter::with('carton', 'carton.cartonlocation', 'carton.product', 'carton.product.codes', 'user')->whereHas('carton.product', function ($q) {
                    $q->whereIn('fish_type', $this->variety);
                    $q->whereDate('carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('carton_date', '<=', $this->endDate->format('Y-m-d'));
                })->whereIn('grade_id', $this->grade);

                $this->total = DB::table("process__qualityparameters")
                    ->join('process__cartons', 'process__cartons.id', '=', 'process__qualityparameters.carton_id')
                    ->join('process__cartonlocations','process__cartonlocations.carton_id','=','process__cartons.id')
                    ->join('process__products', 'process__cartons.product_id', '=', 'process__products.id')
                    ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'), DB::raw('SUM(process__cartonlocations.available_quantity) as avl'))
                    ->whereIn('grade_id', $this->grade)
                    ->whereIn('process__products.fish_type', $this->variety)
                    ->whereDate('process__products.carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('process__products.carton_date', '<=', $this->endDate->format('Y-m-d'))
                    ->get();
            } else {
                $queryBuilder = QualityParameter::with('carton', 'carton.cartonlocation', 'carton.product', 'carton.product.codes', 'user')->whereHas('carton.product', function ($q) {
                    $q->whereIn('fish_type', $this->variety);
                    $q->whereDate('carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('carton_date', '<=', $this->endDate->format('Y-m-d'));
                });

                $this->total = DB::table("process__qualityparameters")
                    ->join('process__cartons', 'process__cartons.id', '=', 'process__qualityparameters.carton_id')
                    ->join('process__cartonlocations','process__cartonlocations.carton_id','=','process__cartons.id')
                    ->join('process__products', 'process__cartons.product_id', '=', 'process__products.id')
                    ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'), DB::raw('SUM(process__cartonlocations.available_quantity) as avl'))
                    ->whereIn('process__products.fish_type', $this->variety)
                    ->whereDate('process__products.carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('process__products.carton_date', '<=', $this->endDate->format('Y-m-d'))
                    ->get();
            }

        } else {
            if ($this->grade != null || $this->grade != "") {
                foreach ($this->grade as $grade) {
                    $this->grades [] = app(GradeRepository::class)->find($grade);
                }
            }

            foreach ($this->variety as $variety) {
                $this->fishtypes [] = app(FishTypeRepository::class)->find($variety);
            }

            $this->date = '';


            if ($this->grade != null || $this->grade != "") {
                $queryBuilder = QualityParameter::with('carton', 'carton.cartonlocation', 'carton.product', 'carton.product.codes', 'user')->whereHas('carton.product', function ($q) {
                    $q->whereIn('fish_type', $this->variety);
                })->whereIn('grade_id', $this->grade);

                $this->total = DB::table("process__qualityparameters")
                    ->join('process__cartons', 'process__cartons.id', '=', 'process__qualityparameters.carton_id')
                    ->join('process__cartonlocations','process__cartonlocations.carton_id','=','process__cartons.id')
                    ->join('process__products', 'process__cartons.product_id', '=', 'process__products.id')
                    ->select('process__qualityparameters.grade_id', 'process__products.fish_type', DB::raw('SUM(process__cartons.no_of_cartons) as total'), DB::raw('SUM(process__cartonlocations.available_quantity) as avl'))
                    ->whereIn('process__qualityparameters.grade_id', $this->grade, 'AND')
                    ->whereIn('process__products.fish_type', $this->variety)
                    ->get();
            } else {
                $queryBuilder = QualityParameter::with('carton', 'carton.cartonlocation', 'carton.product', 'carton.product.codes', 'user')->whereHas('carton.product', function ($q) {
                    $q->whereIn('fish_type', $this->variety);
                });

                $this->total = DB::table("process__qualityparameters")
                    ->join('process__cartons', 'process__cartons.id', '=', 'process__qualityparameters.carton_id')
                    ->join('process__cartonlocations','process__cartonlocations.carton_id','=','process__cartons.id')
                    ->join('process__products', 'process__cartons.product_id', '=', 'process__products.id')
                    ->select('process__qualityparameters.grade_id', 'process__products.fish_type', DB::raw('SUM(process__products.no_of_cartons) as total') , DB::raw('SUM(process__cartonlocations.available_quantity) as avl'))
                    ->whereIn('process__products.fish_type', $this->variety)
                    ->get();
            }


        }

//            $grade = app(GradeRepository::class)->find($this->grade);
//            $this->date = 'Grade: ' . $grade->grade ;

//            dd($this->total);

//        else if($this->variety != null || $this->variety != "") {
//
//            $fishtype = app(FishTypeRepository::class)->find($this->variety);
//            $this->date = 'Fish Type: ' . $fishtype->type ;
//            $queryBuilder = QualityParameter::with('carton', 'carton.cartonlocation', 'carton.product', 'carton.product.codes', 'user')->whereHas('carton.product', function ($q) {
//                $q->where('fish_type', $this->variety);
//            });
//
//            $this->total = DB::table("process__qualityparameters")
//                ->join('process__cartons','process__cartons.id','=','process__qualityparameters.carton_id')
//                ->join('process__products','process__cartons.product_id','=','process__products.id')
//                ->join('process__cartonlocations','process__cartonlocations.carton_id','=','process__cartons.id')
//                ->select(DB::raw('SUM(process__cartonlocations.available_quantity) as total'))
//                ->where('fish_type',$this->variety)
//                ->get();
//
//        }
//        else
//        {

//            $queryBuilder = QualityParameter::with('carton', 'carton.cartonlocation', 'carton.product', 'carton.product.codes', 'user')->whereHas('carton.product', function ($q) {
//                $q->whereDate('carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('carton_date', '<=', $this->endDate->format('Y-m-d'));
//            });
//
//            $this->total = DB::table("process__qualityparameters")
//                ->join('process__cartons','process__cartons.id','=','process__qualityparameters.carton_id')
//                ->join('process__products','process__cartons.product_id','=','process__products.id')
//                ->join('process__cartonlocations','process__cartonlocations.carton_id','=','process__cartons.id')
//                ->select(DB::raw('SUM(process__cartonlocations.available_quantity) as total'))
//                ->whereDate('process__products.carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('process__products.carton_date', '<=', $this->endDate->format('Y-m-d'))
//                ->get();


          $this->data = $queryBuilder->orderby('carton_id')->get();

        $this->setupDone = true;

    }
}