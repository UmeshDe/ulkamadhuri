<?php
namespace Modules\Reports\Reports;


use     Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\FishTypeRepository;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Repositories\LocationRepository;
use Modules\Admin\Repositories\BuyercodeRepository;
use Modules\Admin\Repositories\ApprovalNumberRepository;
use Modules\Admin\Repositories\CheckmarkRepository;
use Modules\Admin\Repositories\BagcolorRepository;
use Modules\Admin\Repositories\CodeMasterRepository;
use Modules\Process\Entities\Carton;
use Modules\Process\Entities\Shipment;
use Modules\Process\Entities\ShipmentCarton;
use Carbon\Carbon;
use PDF;

class ConsolidatedStockReport extends AbstractReport
{
    public $columns = [];
    public $fishTypes;
    public $types;
    public $gradeSum;
    public $grades;
    public $date;
    public $locations;
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


//        dd($this->bagcolor);

        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->reportMaster->footer = ' Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name .' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;

        
        $this->fishTypes = app(FishTypeRepository::class)->all()->sortBy('type');
        $this->grades = app(GradeRepository::class)->all();

        foreach ($this->place as $location)
        {
            $this->locations [] = app(LocationRepository::class)->find($location);
        }

        foreach($this->variety as $variety)
        {
            $this->types [] = app(FishTypeRepository::class)->find($variety);
        }

//        foreach ($this->buyer as $buyer)
//        {
//            $this->buyercode [] = app(BuyercodeRepository::class)->find($buyer);
//        }

        foreach ($this->bagcolor as $bagcolor)
        {
            $this->color [] = app(BagcolorRepository::class)->find($bagcolor);
        }

        foreach ($this->eia as $eia)
        {
            $this->approval [] = app(ApprovalNumberRepository::class)->find($eia);
        }


        foreach ($this->cm as $cm)
        {
            $this->checkmark [] = app(CheckmarkRepository::class)->find($cm);
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

//        foreach ($this->lc as $lc)
//        {
//            $this->lccode [] = app(CodeMasterRepository::class)->find($lc);
//        }

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

        if($this->place != null || $this->place != "")
        {

            $this->reportMaster->sub_title = 'Place :' ;

            $this->gradeSum = DB::table("process__qualityparameters")
                ->join('process__cartons', 'process__cartons.id', '=', 'process__qualityparameters.carton_id')
                ->join('process__products', 'process__cartons.product_id', '=', 'process__products.id')
                ->select('grade_id', 'fish_type', DB::raw('SUM(process__cartons.no_of_cartons) as total_sales'))
                ->groupBy('grade_id', 'fish_type')
                ->whereIn('process__cartons.location_id', $this->place,'AND')
//                ->whereIn('process__products.buyercode_id', $this->buyer,'AND')
                ->whereIn('process__products.fish_type', $this->variety,'AND')
//                ->whereIn('process__products.po_no', $this->po,'AND')
                ->whereIn('process__products.bag_color', $this->bagcolor,'AND')
                ->whereIn('process__products.fm_id', $this->fm,'AND')
                ->whereIn('process__products.d_id', $this->d,'AND')
                ->whereIn('process__products.s_id', $this->s,'AND')
                ->whereIn('process__products.a_id', $this->a,'AND')
                ->whereIn('process__products.c_id', $this->c,'AND')
                ->whereIn('process__products.p_id', $this->p,'AND')
                ->whereIn('process__products.b_id', $this->b,'AND')
                ->whereIn('process__products.m_id', $this->m,'AND')
                ->whereIn('process__products.w_id', $this->w,'AND')
                ->whereIn('process__products.q_id', $this->q,'AND')
                ->whereIn('process__products.sc_id', $this->sc,'AND')
                ->whereIn('process__products.lc_id', $this->lc,'AND')
                ->whereIn('process__products.i_id', $this->i,'AND')
                ->whereIn('process__products.k_id', $this->k,'AND')
                ->whereIn('process__products.e_id', $this->e,'AND')
                ->whereIn('process__products.t_id', $this->t,'AND')
                ->whereIn('process__products.sg_id', $this->sg,'AND')
                ->whereIn('process__products.kg_id', $this->kg,'AND')
                ->whereIn('process__products.g_id', $this->g,'AND')
                ->whereIn('process__products.h_id', $this->h,'AND')
                ->whereIn('process__products.rc_id', $this->rc,'AND')
                ->whereIn('process__products.mk_id', $this->mk,'AND')
                ->whereIn('cm_id',$this->cm,'AND')
                ->whereIn('approval_no',$this->eia)
//                ->whereDate('process__cartons.carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('process__cartons.carton_date', '<=', $this->endDate->format('Y-m-d'))
                ->get();

            $this->ungraded = DB::table("process__cartons")
                ->join('process__products', 'process__products.id', '=', 'process__cartons.product_id')
                ->select('process__products.fish_type', DB::raw('SUM(process__cartons.no_of_cartons) as total_sales'))
                ->where('qualitycheckdone', false)
                ->groupBy('process__products.fish_type')
//                ->whereIn('process__cartons.location_id', $this->place)
                ->whereIn('process__cartons.location_id', $this->place,'AND')
//                ->whereIn('process__products.buyercode_id', $this->buyer,'AND')
                ->whereIn('process__products.fish_type', $this->variety,'AND')
//                ->whereIn('process__products.po_no', $this->po,'AND')
                ->whereIn('process__products.bag_color', $this->bagcolor,'AND')
                ->whereIn('process__products.fm_id', $this->fm,'AND')
                ->whereIn('process__products.d_id', $this->d,'AND')
                ->whereIn('process__products.s_id', $this->s,'AND')
                ->whereIn('process__products.a_id', $this->a,'AND')
                ->whereIn('process__products.c_id', $this->c,'AND')
                ->whereIn('process__products.p_id', $this->p,'AND')
                ->whereIn('process__products.b_id', $this->b,'AND')
                ->whereIn('process__products.m_id', $this->m,'AND')
                ->whereIn('process__products.w_id', $this->w,'AND')
                ->whereIn('process__products.q_id', $this->q,'AND')
                ->whereIn('process__products.sc_id', $this->sc,'AND')
                ->whereIn('process__products.lc_id', $this->lc,'AND')
                ->whereIn('process__products.i_id', $this->i,'AND')
                ->whereIn('process__products.k_id', $this->k,'AND')
                ->whereIn('process__products.e_id', $this->e,'AND')
                ->whereIn('process__products.t_id', $this->t,'AND')
                ->whereIn('process__products.sg_id', $this->sg,'AND')
                ->whereIn('process__products.kg_id', $this->kg,'AND')
                ->whereIn('process__products.g_id', $this->g,'AND')
                ->whereIn('process__products.h_id', $this->h,'AND')
                ->whereIn('process__products.rc_id', $this->rc,'AND')
                ->whereIn('process__products.mk_id', $this->mk,'AND')
                ->whereIn('cm_id',$this->cm,'AND')
                ->whereIn('approval_no',$this->eia)
//                ->whereDate('process__cartons.carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('process__cartons.carton_date', '<=', $this->endDate->format('Y-m-d'))
                ->get();
        }

//        else {
//            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
//            {
//                $this->reportMaster->sub_title = 'Carton Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
//            }
//            else{
//                $this->reportMaster->sub_title = 'Carton From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Carton To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
//            }
//            $this->gradeSum = DB::table("process__qualityparameters")
//                ->join('process__cartons', 'process__cartons.id', '=', 'process__qualityparameters.carton_id')
//                ->join('process__products', 'process__cartons.product_id', '=', 'process__products.id')
//                ->select('grade_id', 'fish_type', DB::raw('SUM(process__cartons.no_of_cartons) as total_sales'))
//                ->groupBy('grade_id', 'fish_type')
//                ->whereDate('process__cartons.carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('process__cartons.carton_date', '<=', $this->endDate->format('Y-m-d'))
//                ->get();
////
//            $this->ungraded = DB::table("process__cartons")
//                ->join('process__products', 'process__products.id', '=', 'process__cartons.product_id')
//                ->select('process__products.fish_type', DB::raw('SUM(process__cartons.no_of_cartons) as total_sales'))
//                ->where('qualitycheckdone', false)
//                ->groupBy('process__products.fish_type')
//                ->whereDate('process__cartons.carton_date', '>=', $this->startDate->format('Y-m-d'))->whereDate('process__cartons.carton_date', '<=', $this->endDate->format('Y-m-d'))
//                ->get();
//        }
        $this->setupDone = true;

    }
}