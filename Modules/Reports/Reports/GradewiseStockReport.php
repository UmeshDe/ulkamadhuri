<?php
namespace Modules\Reports\Reports;


use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\BuyercodeRepository;
use Modules\Admin\Repositories\FishTypeRepository;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Repositories\InternalcodeRepository;
use Modules\Admin\Repositories\ApprovalNumberRepository;
use Modules\Admin\Repositories\CheckmarkRepository;
use Modules\Admin\Repositories\LocationRepository;
use Modules\Admin\Repositories\BagcolorRepository;
use Modules\Admin\Repositories\CodeMasterRepository;
use Modules\Process\Entities\QualityParameter;
use Modules\Process\Entities\Shipment;
use Modules\Process\Entities\ShipmentCarton;
use Carbon\Carbon;
use Modules\Process\Repositories\CartonRepository;
use Modules\Process\Repositories\ProductRepository;
use PDF;

class GradewiseStockReport extends AbstractReport
{
    public $columns = [
        'sr_no'=>[
            'column_name'=>'sr_no',
            'display_name'=>'Sr No',
            'type'=> REPORT_ROWNO_COLUMN
        ],
        'ic'=>[
            'column_name'=> 'ic',
            'display_name'=> 'IC',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'internal_code'
        ],
        'product_date'=>[
            'column_name'=>'carton.product',
            'display_name'=>'Production Date',
            'type' => REPORT_RELATION_COLUMN,
            'format'=> REPORT_DATE_FORMAT,
            'relation_column' => 'product_date'
        ],
        'carton_date'=>[
            'column_name'=>'carton',
            'display_name'=>'Carton Date',
            'type' => REPORT_RELATION_COLUMN,
            'format'=> REPORT_DATE_FORMAT,
            'relation_column' => 'carton_date'
        ],
        'fish_type'=>[
            'column_name'=>'carton.product.fishtype',
            'display_name'=>'Variety',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'type'
        ],
        'grade'=>[
            'column_name'=>'grades',
            'display_name'=>'Grade',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'grade'
        ],
        'lot_no' => [
            'column_name'=>'carton.product',
            'display_name'=>'LOT No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'lot_no'
        ],
        'name' => [
            'column_name'=>'carton.location',
            'display_name'=>'City',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'name'
        ],
        'location' => [
            'column_name'=>'carton.location',
            'display_name'=>'Place',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'location'
        ],
        'sublocation' => [
            'column_name'=>'carton.location',
            'display_name'=> 'Chamber/Zone/Floor',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'sublocation'
        ],
        'landmark' => [
            'column_name'=>'carton.location',
            'display_name'=> 'Location',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'landmark'
        ],
        'street' => [
            'column_name'=>'carton.location',
            'display_name'=> 'Pallet No',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'street'
        ],
        'qty' => [
            'column_name'=>'carton',
            'display_name'=> 'Cartons',
            'type' => REPORT_RELATION_COLUMN,
            'relation_column' => 'no_of_cartons'
        ],
    ];

    public $date;
    public $total;
    public $grades;
    public $types;
    public $ics;
    public $locations;
    public $variety;
    public $buyercode;
    public $color;
    public $fmcode;
    public $dcode;
    public $scode;
    public $acode;
    public $ccode;
    public $pcode;
    public $bcode;
    public $mcode;
    public $wcode;
    public $qcode;
    public $sccode;
    public $lccode;
    public $icode;
    public $kcode;
    public $ecode;
    public $tcode;
    public $sgcode;
    public $kgcode;
    public $gcode;
    public $hcode;
    public $rccode;
    public $mkcode;
    public $approval;
    public $checkmark;

    public function setup(){

        $this->reportMaster->sub_title_style = 'text-align:left';
        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;


        //Repositories
        $fishtype = app(FishTypeRepository::class)->find($this->variety);
        $grade = app(GradeRepository::class)->find($this->grade);
        $buyer= app(BuyercodeRepository::class)->find($this->buyer);
//        $ic = app(InternalcodeRepository::class)->find($this->ic);
        $location = app(LocationRepository::class)->find($this->place);




        foreach ($this->place as $location)
        {
            $this->locations [] = app(LocationRepository::class)->find($location);
        }


        foreach($this->variety as $variety)
        {
            $this->types [] = app(FishTypeRepository::class)->find($variety);
        }

        foreach ($this->eia as $eia)
        {
            $this->approval [] = app(ApprovalNumberRepository::class)->find($eia);
        }


        foreach ($this->cm as $cm)
        {
            $this->checkmark [] = app(CheckmarkRepository::class)->find($cm);
        }

//        dd($this->grade);

        if ($this->grade != null) {
            foreach ($this->grade as $grade) {
                $this->grades [] = app(GradeRepository::class)->find($grade);
            }
        }

//        foreach ($this->ic as $ic)
//        {
//            $this->ics [] = app(GradeRepository::class)->find($grade);
//        }

        foreach ($this->bagcolor as $bagcolor)
        {
            $this->color [] = app(BagcolorRepository::class)->find($bagcolor);
        }

        foreach ($this->fm as $fm)
        {
            $this->fmcode [] = app(CodeMasterRepository::class)->find($fm);
        }

        foreach ($this->d as $d)
        {
            $this->dcode [] = app(CodeMasterRepository::class)->find($d);
        }

        foreach ($this->s as $s)
        {
            $this->scode [] = app(CodeMasterRepository::class)->find($s);
        }

        foreach ($this->a as $a)
        {
            $this->acode [] = app(CodeMasterRepository::class)->find($a);
        }

        foreach ($this->c as $c)
        {
            $this->ccode [] = app(CodeMasterRepository::class)->find($c);
        }

        foreach ($this->p as $p)
        {
            $this->pcode [] = app(CodeMasterRepository::class)->find($p);
        }

        foreach ($this->b as $b)
        {
            $this->bcode [] = app(CodeMasterRepository::class)->find($b);
        }

        foreach ($this->m as $m)
        {
            $this->mcode [] = app(CodeMasterRepository::class)->find($m);
        }

        foreach ($this->w as $w)
        {
            $this->wcode [] = app(CodeMasterRepository::class)->find($w);
        }

        foreach ($this->q as $q)
        {
            $this->qcode [] = app(CodeMasterRepository::class)->find($q);
        }

        foreach ($this->sc as $sc)
        {
            $this->sccode [] = app(CodeMasterRepository::class)->find($sc);
        }

        foreach ($this->lc as $lc)
        {
            $this->lccode [] = app(CodeMasterRepository::class)->find($lc);
        }

        foreach ($this->i as $i)
        {
            $this->icode [] = app(CodeMasterRepository::class)->find($i);
        }

        foreach ($this->k as $k)
        {
            $this->kcode [] = app(CodeMasterRepository::class)->find($k);
        }

        foreach ($this->e as $e)
        {
            $this->ecode [] = app(CodeMasterRepository::class)->find($e);
        }

        foreach ($this->t as $t)
        {
            $this->tcode [] = app(CodeMasterRepository::class)->find($t);
        }

        foreach ($this->sg as $sg)
        {
            $this->sgcode [] = app(CodeMasterRepository::class)->find($sg);
        }

        foreach ($this->kg as $kg)
        {
            $this->kgcode [] = app(CodeMasterRepository::class)->find($kg);
        }

        foreach ($this->g as $g)
        {
            $this->gcode [] = app(CodeMasterRepository::class)->find($g);
        }

        foreach ($this->h as $h)
        {
            $this->hcode [] = app(CodeMasterRepository::class)->find($h);
        }

        foreach ($this->rc as $rc)
        {
            $this->rccode [] = app(CodeMasterRepository::class)->find($rc);
        }

        foreach ($this->mk as $mk)
        {
            $this->mkcode [] = app(CodeMasterRepository::class)->find($mk);
        }


            if ($this->reportDate == 1) {
                $this->date = 'Carton From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Carton To Date:' . Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT);

                $queryBuilder = QualityParameter::with('carton', 'grades', 'carton.cartonlocation', 'carton.product', 'ic', 'carton.product.codes', 'user')->whereHas('carton.product', function ($q) {
                    $q->whereIn('fish_type', $this->variety, 'AND');
                    $q->whereIn('bag_color', $this->bagcolor, 'AND');
                    $q->whereIn('fm_id', $this->fm, 'AND');
                    $q->whereIn('d_id', $this->d, 'AND');
                    $q->whereIn('s_id', $this->s, 'AND');
                    $q->whereIn('a_id', $this->a, 'AND');
                    $q->whereIn('c_id', $this->c, 'AND');
                    $q->whereIn('p_id', $this->p, 'AND');
                    $q->whereIn('b_id', $this->b, 'AND');
                    $q->whereIn('m_id', $this->m, 'AND');
                    $q->whereIn('w_id', $this->w, 'AND');
                    $q->whereIn('q_id', $this->q, 'AND');
                    $q->whereIn('sc_id', $this->sc, 'AND');
                    $q->whereIn('lc_id', $this->lc, 'AND');
                    $q->whereIn('i_id', $this->i, 'AND');
                    $q->whereIn('k_id', $this->k, 'AND');
                    $q->whereIn('e_id', $this->e, 'AND');
                    $q->whereIn('t_id', $this->t, 'AND');
                    $q->whereIn('sg_id', $this->sg, 'AND');
                    $q->whereIn('kg_id', $this->kg, 'AND');
                    $q->whereIn('g_id', $this->g, 'AND');
                    $q->whereIn('h_id', $this->h, 'AND');
                    $q->whereIn('rc_id', $this->rc, 'AND');
                    $q->whereIn('mk_id', $this->mk, 'AND');
                    $q->whereIn('cm_id', $this->cm, 'AND');
                    $q->whereIn('approval_no', $this->eia, 'AND');
                    $q->whereDate('carton_date', '>=', $this->startDate);
                    $q->whereDate('carton_date', '<=', $this->endDate);
                })->whereHas('carton', function ($q) {
                    $q->whereIn('location_id', $this->place, 'AND');
                });
//                ->whereIn('ic_id',$this->ic);

                $this->total = DB::table("process__qualityparameters")
                    ->join('process__cartons', 'process__cartons.id', '=', 'process__qualityparameters.carton_id')
                    ->join('process__products', 'process__cartons.product_id', '=', 'process__products.id')
                    ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'))
                    ->whereIn('process__products.fish_type', $this->variety, 'AND')
                    ->whereIn('process__cartons.location_id', $this->place, 'AND')
                    ->whereIn('process__products.bag_color', $this->bagcolor, 'AND')
                    ->whereIn('process__products.fm_id', $this->fm, 'AND')
                    ->whereIn('process__products.d_id', $this->d, 'AND')
                    ->whereIn('process__products.s_id', $this->s, 'AND')
                    ->whereIn('process__products.a_id', $this->a, 'AND')
                    ->whereIn('process__products.c_id', $this->c, 'AND')
                    ->whereIn('process__products.p_id', $this->p, 'AND')
                    ->whereIn('process__products.b_id', $this->b, 'AND')
                    ->whereIn('process__products.m_id', $this->m, 'AND')
                    ->whereIn('process__products.w_id', $this->w, 'AND')
                    ->whereIn('process__products.q_id', $this->q, 'AND')
                    ->whereIn('process__products.sc_id', $this->sc, 'AND')
                    ->whereIn('process__products.lc_id', $this->lc, 'AND')
                    ->whereIn('process__products.i_id', $this->i, 'AND')
                    ->whereIn('process__products.k_id', $this->k, 'AND')
                    ->whereIn('process__products.e_id', $this->e, 'AND')
                    ->whereIn('process__products.t_id', $this->t, 'AND')
                    ->whereIn('process__products.sg_id', $this->sg, 'AND')
                    ->whereIn('process__products.kg_id', $this->kg, 'AND')
                    ->whereIn('process__products.g_id', $this->g, 'AND')
                    ->whereIn('process__products.h_id', $this->h, 'AND')
                    ->whereIn('process__products.rc_id', $this->rc, 'AND')
                    ->whereIn('process__products.mk_id', $this->mk, 'AND')
                    ->whereIn('cm_id', $this->cm, 'AND')
                    ->whereIn('approval_no', $this->eia, 'AND')
//                    ->whereIn('process__qualityparameters.grade_id', $this->grade, 'AND')
                    ->whereDate('process__products.carton_date', '>=', $this->startDate)
                    ->whereDate('process__products.carton_date', '<=', $this->endDate)
//                ->whereIn('process__qualityparameters.ic_id',$this->ic)
                    ->get();

            } elseif ($this->reportDate == 0 && $this->reportDate != null) {
                $this->date = 'Prodution From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Production To Date:' . Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT);

                $queryBuilder = QualityParameter::with('carton', 'grades', 'carton.cartonlocation', 'carton.product', 'ic', 'carton.product.codes', 'user')->whereHas('carton.product', function ($q) {
                    $q->whereIn('fish_type', $this->variety, 'AND');
                    $q->whereIn('bag_color', $this->bagcolor, 'AND');
                    $q->whereIn('fm_id', $this->fm, 'AND');
                    $q->whereIn('d_id', $this->d, 'AND');
                    $q->whereIn('s_id', $this->s, 'AND');
                    $q->whereIn('a_id', $this->a, 'AND');
                    $q->whereIn('c_id', $this->c, 'AND');
                    $q->whereIn('p_id', $this->p, 'AND');
                    $q->whereIn('b_id', $this->b, 'AND');
                    $q->whereIn('m_id', $this->m, 'AND');
                    $q->whereIn('w_id', $this->w, 'AND');
                    $q->whereIn('q_id', $this->q, 'AND');
                    $q->whereIn('sc_id', $this->sc, 'AND');
                    $q->whereIn('lc_id', $this->lc, 'AND');
                    $q->whereIn('i_id', $this->i, 'AND');
                    $q->whereIn('k_id', $this->k, 'AND');
                    $q->whereIn('e_id', $this->e, 'AND');
                    $q->whereIn('t_id', $this->t, 'AND');
                    $q->whereIn('sg_id', $this->sg, 'AND');
                    $q->whereIn('kg_id', $this->kg, 'AND');
                    $q->whereIn('g_id', $this->g, 'AND');
                    $q->whereIn('h_id', $this->h, 'AND');
                    $q->whereIn('rc_id', $this->rc, 'AND');
                    $q->whereIn('mk_id', $this->mk, 'AND');
                    $q->whereIn('cm_id', $this->cm, 'AND');
                    $q->whereIn('approval_no', $this->eia, 'AND');
                    $q->whereDate('product_date', '>=', $this->startDate);
                    $q->whereDate('product_date', '<=', $this->endDate);
                })->whereHas('carton', function ($q) {
                    $q->whereIn('location_id', $this->place, 'AND');
                });
//                ->whereIn('ic_id',$this->ic);

                $this->total = DB::table("process__qualityparameters")
                    ->join('process__cartons', 'process__cartons.id', '=', 'process__qualityparameters.carton_id')
                    ->join('process__products', 'process__cartons.product_id', '=', 'process__products.id')
                    ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'))
                    ->whereIn('process__products.fish_type', $this->variety, 'AND')
                    ->whereIn('process__cartons.location_id', $this->place, 'AND')
                    ->whereIn('process__products.bag_color', $this->bagcolor, 'AND')
                    ->whereIn('process__products.fm_id', $this->fm, 'AND')
                    ->whereIn('process__products.d_id', $this->d, 'AND')
                    ->whereIn('process__products.s_id', $this->s, 'AND')
                    ->whereIn('process__products.a_id', $this->a, 'AND')
                    ->whereIn('process__products.c_id', $this->c, 'AND')
                    ->whereIn('process__products.p_id', $this->p, 'AND')
                    ->whereIn('process__products.b_id', $this->b, 'AND')
                    ->whereIn('process__products.m_id', $this->m, 'AND')
                    ->whereIn('process__products.w_id', $this->w, 'AND')
                    ->whereIn('process__products.q_id', $this->q, 'AND')
                    ->whereIn('process__products.sc_id', $this->sc, 'AND')
                    ->whereIn('process__products.lc_id', $this->lc, 'AND')
                    ->whereIn('process__products.i_id', $this->i, 'AND')
                    ->whereIn('process__products.k_id', $this->k, 'AND')
                    ->whereIn('process__products.e_id', $this->e, 'AND')
                    ->whereIn('process__products.t_id', $this->t, 'AND')
                    ->whereIn('process__products.sg_id', $this->sg, 'AND')
                    ->whereIn('process__products.kg_id', $this->kg, 'AND')
                    ->whereIn('process__products.g_id', $this->g, 'AND')
                    ->whereIn('process__products.h_id', $this->h, 'AND')
                    ->whereIn('process__products.rc_id', $this->rc, 'AND')
                    ->whereIn('process__products.mk_id', $this->mk, 'AND')
                    ->whereIn('cm_id', $this->cm, 'AND')
                    ->whereIn('approval_no', $this->eia, 'AND')
//                    ->whereIn('process__qualityparameters.grade_id', $this->grade, 'AND')
                    ->whereDate('process__products.product_date', '>=', $this->startDate)
                    ->whereDate('process__products.product_date', '<=', $this->endDate)
//                ->whereIn('process__qualityparameters.ic_id',$this->ic)
                    ->get();
            } else {
                $this->date = "";

                $queryBuilder = QualityParameter::with('carton', 'grades', 'carton.cartonlocation', 'carton.product', 'ic', 'carton.product.codes', 'user')->whereHas('carton.product', function ($q) {
                    $q->whereIn('fish_type', $this->variety, 'AND');
                    $q->whereIn('bag_color', $this->bagcolor, 'AND');
                    $q->whereIn('fm_id', $this->fm, 'AND');
                    $q->whereIn('d_id', $this->d, 'AND');
                    $q->whereIn('s_id', $this->s, 'AND');
                    $q->whereIn('a_id', $this->a, 'AND');
                    $q->whereIn('c_id', $this->c, 'AND');
                    $q->whereIn('p_id', $this->p, 'AND');
                    $q->whereIn('b_id', $this->b, 'AND');
                    $q->whereIn('m_id', $this->m, 'AND');
                    $q->whereIn('w_id', $this->w, 'AND');
                    $q->whereIn('q_id', $this->q, 'AND');
                    $q->whereIn('sc_id', $this->sc, 'AND');
                    $q->whereIn('lc_id', $this->lc, 'AND');
                    $q->whereIn('i_id', $this->i, 'AND');
                    $q->whereIn('k_id', $this->k, 'AND');
                    $q->whereIn('e_id', $this->e, 'AND');
                    $q->whereIn('t_id', $this->t, 'AND');
                    $q->whereIn('sg_id', $this->sg, 'AND');
                    $q->whereIn('kg_id', $this->kg, 'AND');
                    $q->whereIn('g_id', $this->g, 'AND');
                    $q->whereIn('h_id', $this->h, 'AND');
                    $q->whereIn('rc_id', $this->rc, 'AND');
                    $q->whereIn('mk_id', $this->mk, 'AND');
                    $q->whereIn('cm_id', $this->cm, 'AND');
                    $q->whereIn('approval_no', $this->eia, 'AND');
                })->whereHas('carton', function ($q) {
                    $q->whereIn('location_id', $this->place, 'AND');
                });
//                ->whereIn('ic_id',$this->ic);

                $this->total = DB::table("process__qualityparameters")
                    ->join('process__cartons', 'process__cartons.id', '=', 'process__qualityparameters.carton_id')
                    ->join('process__products', 'process__cartons.product_id', '=', 'process__products.id')
                    ->select(DB::raw('SUM(process__cartons.no_of_cartons) as total'))
                    ->whereIn('process__products.fish_type', $this->variety, 'AND')
                    ->whereIn('process__cartons.location_id', $this->place, 'AND')
                    ->whereIn('process__products.bag_color', $this->bagcolor, 'AND')
                    ->whereIn('process__products.fm_id', $this->fm, 'AND')
                    ->whereIn('process__products.d_id', $this->d, 'AND')
                    ->whereIn('process__products.s_id', $this->s, 'AND')
                    ->whereIn('process__products.a_id', $this->a, 'AND')
                    ->whereIn('process__products.c_id', $this->c, 'AND')
                    ->whereIn('process__products.p_id', $this->p, 'AND')
                    ->whereIn('process__products.b_id', $this->b, 'AND')
                    ->whereIn('process__products.m_id', $this->m, 'AND')
                    ->whereIn('process__products.w_id', $this->w, 'AND')
                    ->whereIn('process__products.q_id', $this->q, 'AND')
                    ->whereIn('process__products.sc_id', $this->sc, 'AND')
                    ->whereIn('process__products.lc_id', $this->lc, 'AND')
                    ->whereIn('process__products.i_id', $this->i, 'AND')
                    ->whereIn('process__products.k_id', $this->k, 'AND')
                    ->whereIn('process__products.e_id', $this->e, 'AND')
                    ->whereIn('process__products.t_id', $this->t, 'AND')
                    ->whereIn('process__products.sg_id', $this->sg, 'AND')
                    ->whereIn('process__products.kg_id', $this->kg, 'AND')
                    ->whereIn('process__products.g_id', $this->g, 'AND')
                    ->whereIn('process__products.h_id', $this->h, 'AND')
                    ->whereIn('process__products.rc_id', $this->rc, 'AND')
                    ->whereIn('process__products.mk_id', $this->mk, 'AND')
                    ->whereIn('cm_id', $this->cm, 'AND')
                    ->whereIn('approval_no', $this->eia, 'AND')
                    ->whereIn('process__qualityparameters.grade_id', $this->grade, 'AND')
//                ->whereIn('process__qualityparameters.ic_id',$this->ic)
                    ->get();

            }

        $this->data = $queryBuilder->get();

        $this->setupDone = true;
    }
}