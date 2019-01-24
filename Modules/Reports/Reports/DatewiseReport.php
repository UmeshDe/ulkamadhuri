<?php

namespace Modules\Reports\Reports;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Process\Entities\Product;
use Modules\Process\Repositories\ProductRepository;
use Modules\Admin\Repositories\FishTypeRepository;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Repositories\LocationRepository;
use Modules\Admin\Repositories\ApprovalNumberRepository;
use Modules\Admin\Repositories\CheckmarkRepository;
use Modules\Admin\Repositories\BuyercodeRepository;
use Modules\Admin\Repositories\BagcolorRepository;
use Modules\Admin\Repositories\CodeMasterRepository;
use PDF;

class DatewiseReport extends AbstractReport
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
        'product_date'=> [
            'column_name'=>'product_date',
            'display_name'=>'Production Date',
            'format'=> REPORT_DATE_FORMAT,
        ],
        'date'=> [
            'column_name'=>'carton_date',
            'display_name'=>'Carton Date',
            'format'=> REPORT_DATE_FORMAT
        ],
        'variety'=> [
            'column_name'=>'fishtype',
            'display_name'=>'Varity',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'type'
        ],
        'cm'=> [
            'column_name'=>'cm',
            'display_name'=>'CM',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'cm'
        ],
        'first_lot_no'=>[
            'column_name'=>'lot_no',
            'display_name'=>'1ST Lot No',
        ],
        'last_lot_no' => [
            'column_name'=>'last',
            'display_name'=>'Last Lot No',
            'type' => REPORT_MULRELATION_COLUMN,
            'relation_column' => ''
        ],
        'no_of_lab'=> [
            'column_name' => 'product_slab',
            'display_name' => 'Last Lot Slab No.',
        ] ,
        'no_of_cartons'=>[
            'column_name'=>'no_of_cartons',
            'display_name'=>'Total Cartons',
        ],
        'Remark'=>[
            'column_name'=>'remark',
            'display_name'=>'Production Remark',
        ],
    ];
    
    public $date;
    public $fishTypes;
    public $types;
    public $gradeSum;
    public $grades;
    public $pos;
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

    public $lastlot;

    public function formatCode($codes){
        return count($codes);
    }

    public function setup(){

        $this->reportMaster->sub_title_style = 'text-align:left';

        foreach($this->variety as $variety)
        {
            $this->types [] = app(FishTypeRepository::class)->find($variety);
        }

//        foreach ($this->po as $po)
//        {
//            $this->pos [] = app(ProductRepository::class)->find($po);
//        }

        foreach ($this->eia as $eia)
        {
            $this->approval [] = app(ApprovalNumberRepository::class)->find($eia);
        }


        foreach ($this->cm as $cm)
        {
            $this->checkmark [] = app(CheckmarkRepository::class)->find($cm);
        }

//        foreach ($this->buyer as $buyer)
//        {
//            $this->buyercode [] = app(BuyercodeRepository::class)->find($buyer);
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


        if($this->reportDate == 0)
        {
            if(Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT))
            {
                $this->date = 'Production Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) ;
            }
            else{
                $this->date = 'Production From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Production To Date:' .Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT) ;
            }

//            $queryBuilder = Product::with('codes','lastlot','variety','bagColor','cartonType')->whereDate('product_date' , '>=' , $this->startDate->format('Y-m-d'))->whereDate('product_date' ,'<=',$this->endDate->format('Y-m-d'));


            $queryBuilder = DB::table("process__products")
                ->join('admin__fishtypes', 'admin__fishtypes.id', '=', 'process__products.fish_type')
                ->join('admin__checkmarks', 'admin__checkmarks.id', '=', 'process__products.cm_id')
                ->select('product_date','carton_date', 'admin__fishtypes.type','remark','admin__checkmarks.cm','product_slab',DB::raw('MIN(process__products.lot_no) as firstlot'), DB::raw('MAX(process__products.lot_no) as lastlot'),DB::raw('SUM(process__products.no_of_cartons) as total'))
                ->groupBy('product_date', 'fish_type')
                ->whereIn('process__products.bag_color',$this->bagcolor,'AND')
//                    ->whereIn('process__products.buyercode_id', $this->buyer,'AND')
                ->whereIn('process__products.fm_id',$this->fm,'AND')
                ->whereIn('process__products.d_id',$this->d,'AND')
                ->whereIn('process__products.s_id',$this->s,'AND')
                ->whereIn('process__products.a_id',$this->a,'AND')
                ->whereIn('process__products.c_id',$this->c,'AND')
                ->whereIn('process__products.p_id',$this->p,'AND')
                ->whereIn('process__products.b_id',$this->b,'AND')
                ->whereIn('process__products.m_id',$this->m,'AND')
                ->whereIn('process__products.w_id',$this->w,'AND')
                ->whereIn('process__products.q_id',$this->q,'AND')
                ->whereIn('process__products.sc_id',$this->sc,'AND')
                ->whereIn('process__products.lc_id',$this->lc,'AND')
                ->whereIn('process__products.i_id',$this->i,'AND')
                ->whereIn('process__products.k_id',$this->k,'AND')
                ->whereIn('process__products.e_id',$this->e,'AND')
                ->whereIn('process__products.t_id',$this->t,'AND')
                ->whereIn('process__products.sg_id',$this->sg,'AND')
                ->whereIn('process__products.kg_id',$this->kg,'AND')
                ->whereIn('process__products.g_id',$this->g,'AND')
                ->whereIn('process__products.h_id',$this->h,'AND')
                ->whereIn('process__products.rc_id',$this->rc,'AND')
                ->whereIn('process__products.mk_id',$this->mk,'AND')
                ->whereIn('process__products.cm_id',$this->cm,'AND')
                ->whereIn('process__products.approval_no',$this->eia,'AND')
                ->whereIn('process__products.fish_type', $this->variety,'AND')
                ->where('process__products.status', 'active','AND')
//                    ->whereIn('process__products.po_no', $this->po,'AND')
                ->whereDate('process__products.product_date','>=', $this->startDate)
                ->whereDate('process__products.product_date','<=', $this->endDate);

//            dd($queryBuilder);

            $this->sum = app(ProductRepository::class)->allWithBuilder()
                ->whereIn('process__products.bag_color',$this->bagcolor,'AND')
//                    ->whereIn('process__products.buyercode_id', $this->buyer,'AND')
                ->whereIn('process__products.fm_id',$this->fm,'AND')
                ->whereIn('process__products.d_id',$this->d,'AND')
                ->whereIn('process__products.s_id',$this->s,'AND')
                ->whereIn('process__products.a_id',$this->a,'AND')
                ->whereIn('process__products.c_id',$this->c,'AND')
                ->whereIn('process__products.p_id',$this->p,'AND')
                ->whereIn('process__products.b_id',$this->b,'AND')
                ->whereIn('process__products.m_id',$this->m,'AND')
                ->whereIn('process__products.w_id',$this->w,'AND')
                ->whereIn('process__products.q_id',$this->q,'AND')
                ->whereIn('process__products.sc_id',$this->sc,'AND')
                ->whereIn('process__products.lc_id',$this->lc,'AND')
                ->whereIn('process__products.i_id',$this->i,'AND')
                ->whereIn('process__products.k_id',$this->k,'AND')
                ->whereIn('process__products.e_id',$this->e,'AND')
                ->whereIn('process__products.t_id',$this->t,'AND')
                ->whereIn('process__products.sg_id',$this->sg,'AND')
                ->whereIn('process__products.kg_id',$this->kg,'AND')
                ->whereIn('process__products.g_id',$this->g,'AND')
                ->whereIn('process__products.h_id',$this->h,'AND')
                ->whereIn('process__products.rc_id',$this->rc,'AND')
                ->whereIn('process__products.mk_id',$this->mk,'AND')
                ->whereIn('process__products.cm_id',$this->cm,'AND')
                ->whereIn('process__products.approval_no',$this->eia,'AND')
                ->whereIn('process__products.fish_type', $this->variety,'AND')
                ->where('process__products.status', 'active','AND')
//                    ->whereIn('process__products.po_no', $this->po,'AND')
                ->whereDate('product_date' , '>=' ,  $this->startDate)
                ->whereDate('product_date' , '<=' ,  $this->endDate)
                ->sum('no_of_cartons');

//            $this->lastlot = app(ProductRepository::class)->all()
//                ->whereDate('product_date', $this->startDate)
//                ->whereDate('product_date', $this->endDate);

            $this->reportMaster->subfooter = $this->sum;

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

            $queryBuilder = DB::table("process__products")
                ->join('admin__fishtypes', 'admin__fishtypes.id', '=', 'process__products.fish_type')
                ->join('admin__checkmarks', 'admin__checkmarks.id', '=', 'process__products.cm_id')
                ->select('product_date','carton_date' ,'admin__fishtypes.type','remark','admin__checkmarks.cm','product_slab',DB::raw('MIN(process__products.lot_no) as firstlot'), DB::raw('MAX(process__products.lot_no) as lastlot'),DB::raw('SUM(process__products.no_of_cartons) as total'))
                ->groupBy('product_date', 'fish_type')
                ->whereIn('process__products.bag_color',$this->bagcolor,'AND')
//                    ->whereIn('process__products.buyercode_id', $this->buyer,'AND')
                ->whereIn('process__products.fm_id',$this->fm,'AND')
                ->whereIn('process__products.d_id',$this->d,'AND')
                ->whereIn('process__products.s_id',$this->s,'AND')
                ->whereIn('process__products.a_id',$this->a,'AND')
                ->whereIn('process__products.c_id',$this->c,'AND')
                ->whereIn('process__products.p_id',$this->p,'AND')
                ->whereIn('process__products.b_id',$this->b,'AND')
                ->whereIn('process__products.m_id',$this->m,'AND')
                ->whereIn('process__products.w_id',$this->w,'AND')
                ->whereIn('process__products.q_id',$this->q,'AND')
                ->whereIn('process__products.sc_id',$this->sc,'AND')
                ->whereIn('process__products.lc_id',$this->lc,'AND')
                ->whereIn('process__products.i_id',$this->i,'AND')
                ->whereIn('process__products.k_id',$this->k,'AND')
                ->whereIn('process__products.e_id',$this->e,'AND')
                ->whereIn('process__products.t_id',$this->t,'AND')
                ->whereIn('process__products.sg_id',$this->sg,'AND')
                ->whereIn('process__products.kg_id',$this->kg,'AND')
                ->whereIn('process__products.g_id',$this->g,'AND')
                ->whereIn('process__products.h_id',$this->h,'AND')
                ->whereIn('process__products.rc_id',$this->rc,'AND')
                ->whereIn('process__products.mk_id',$this->mk,'AND')
                ->whereIn('process__products.cm_id',$this->cm,'AND')
                ->whereIn('process__products.approval_no',$this->eia,'AND')
                ->whereIn('process__products.fish_type', $this->variety,'AND')
                ->where('process__products.status', 'active','AND')
//                    ->whereIn('process__products.po_no', $this->po,'AND')
                ->whereDate('process__products.carton_date','>=', $this->startDate)
                ->whereDate('process__products.carton_date','<=', $this->endDate);

            $this->sum = app(ProductRepository::class)->allWithBuilder()
                ->whereIn('process__products.bag_color',$this->bagcolor,'AND')
//                    ->whereIn('process__products.buyercode_id', $this->buyer,'AND')
                ->whereIn('process__products.fm_id',$this->fm,'AND')
                ->whereIn('process__products.d_id',$this->d,'AND')
                ->whereIn('process__products.s_id',$this->s,'AND')
                ->whereIn('process__products.a_id',$this->a,'AND')
                ->whereIn('process__products.c_id',$this->c,'AND')
                ->whereIn('process__products.p_id',$this->p,'AND')
                ->whereIn('process__products.b_id',$this->b,'AND')
                ->whereIn('process__products.m_id',$this->m,'AND')
                ->whereIn('process__products.w_id',$this->w,'AND')
                ->whereIn('process__products.q_id',$this->q,'AND')
                ->whereIn('process__products.sc_id',$this->sc,'AND')
                ->whereIn('process__products.lc_id',$this->lc,'AND')
                ->whereIn('process__products.i_id',$this->i,'AND')
                ->whereIn('process__products.k_id',$this->k,'AND')
                ->whereIn('process__products.e_id',$this->e,'AND')
                ->whereIn('process__products.t_id',$this->t,'AND')
                ->whereIn('process__products.sg_id',$this->sg,'AND')
                ->whereIn('process__products.kg_id',$this->kg,'AND')
                ->whereIn('process__products.g_id',$this->g,'AND')
                ->whereIn('process__products.h_id',$this->h,'AND')
                ->whereIn('process__products.rc_id',$this->rc,'AND')
                ->whereIn('process__products.mk_id',$this->mk,'AND')
                ->whereIn('process__products.cm_id',$this->cm,'AND')
                ->whereIn('process__products.approval_no',$this->eia,'AND')
                ->whereIn('process__products.fish_type', $this->variety,'AND')
                ->where('process__products.status', 'active','AND')
//                    ->whereIn('process__products.po_no', $this->po,'AND')
                ->whereDate('carton_date' , '>=' ,  $this->startDate)
                ->whereDate('carton_date' , '<=' ,  $this->endDate)
                ->sum('no_of_cartons');

            $this->reportMaster->subfooter = $this->sum;
        }

        $this->reportMaster->footer = 'Printed by :'.  auth()->user()->first_name." ".auth()->user()->last_name . ' , ' .'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT) ;


        $last = $this->lastlot;
        $this->data = $queryBuilder->get();

        $this->setupDone = true;
    }
}