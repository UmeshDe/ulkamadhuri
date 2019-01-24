<?php

namespace Modules\Reports\Reports;


use Carbon\Carbon;
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

class DailyProductionReport extends AbstractReport
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
            'column_name'=>'product_date',
            'display_name'=>'Production Date',
            'format'=> REPORT_DATE_FORMAT
        ],
        'carton_date'=> [
            'column_name'=>'carton_date',
            'display_name'=>'CartonDate',
            'format'=> REPORT_DATE_FORMAT,
        ],
        'approval_no'=>[
            'column_name'=>'approval',
            'display_name'=>'EIA No',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'app_number'
        ],
        'variety'=> [
            'column_name'=>'variety',
            'display_name'=>'Varity',
        ],
        'cm'=> [
            'column_name'=>'cm',
            'display_name'=>'CM',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'cm'
        ],
        'lot_no'=>[
            'column_name'=>'lot_no',
            'display_name'=>'Lot',
        ],
        'no_of_lab'=> [
           'column_name' => 'product_slab',
           'display_name' => 'Slab',
        ] ,
        'bag_color'=> [
            'column_name'=>'bagColor',
            'display_name'=>'Bag Color',
        ],
        'po_no'=>[
            'column_name'=>'po_no',
            'display_name'=>'PO',
        ],
        'fm' => [
            'column_name'=>'fm',
            'display_name'=>'FM',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'i' => [
            'column_name'=>'i',
            'display_name'=>'I',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'k' => [
            'column_name'=>'k',
            'display_name'=>'K',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'e' => [
            'column_name'=>'e',
            'display_name'=>'E',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        't' => [
            'column_name'=>'t',
            'display_name'=>'T',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'sg' => [
            'column_name'=>'sg',
            'display_name'=>'SG',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'kg' => [
            'column_name'=>'kg',
            'display_name'=>'KG',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'g' => [
            'column_name'=>'g',
            'display_name'=>'G',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'h' => [
            'column_name'=>'h',
            'display_name'=>'H',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'rc' => [
            'column_name'=>'rc',
            'display_name'=>'RC',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'mk' => [
            'column_name'=>'mk',
            'display_name'=>'MK',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'kt' => [
            'column_name'=>'fr',
            'display_name'=>'KT',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'v' => [
            'column_name'=>'v',
            'display_name'=>'V',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'd' => [
            'column_name'=>'d',
            'display_name'=>'D',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        's' => [
            'column_name'=>'s',
            'display_name'=>'S',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'a' => [
            'column_name'=>'a',
            'display_name'=>'A',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'c' => [
            'column_name'=>'c',
            'display_name'=>'C',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'p' => [
            'column_name'=>'p',
            'display_name'=>'P',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'b' => [
            'column_name'=>'b',
            'display_name'=>'B',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'm' => [
            'column_name'=>'m',
            'display_name'=>'M',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'w' => [
            'column_name'=>'w',
            'display_name'=>'W',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'q' => [
            'column_name'=>'Q',
            'display_name'=>'Q',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'sc' => [
            'column_name'=>'sc',
            'display_name'=>'SC',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'lc' => [
            'column_name'=>'lc',
            'display_name'=>'LC',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'code'
        ],
        'bc' =>[
            'column_name'=>'buyer',
            'display_name'=>'Buyercode',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'buyer_code'
        ],
        'no_of_cartons'=>[
            'column_name'=>'no_of_cartons',
            'display_name'=>'Cartons',
        ],
        'Remark'=>[
            'column_name'=>'remark',
            'display_name'=>'Remark',
        ],
        'production_done'=>[
            'column_name'=>'user',
            'display_name'=> 'Done By',
            'type'=>REPORT_RELATION_COLUMN,
            'relation_column' =>'first_name'
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
    public $frcode;
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


    public function formatCode($codes){
        return count($codes);
    }

    public function setup()
    {


        $this->reportMaster->sub_title_style = 'text-align:left';

        $this->reportMaster->footer = ' Printed by :' . auth()->user()->first_name . " " . auth()->user()->last_name . ' , ' . 'Date & Time :' . Carbon::now()->format(PHP_DATE_TIME_FORMAT);


        foreach ($this->variety as $variety) {
            $this->types [] = app(FishTypeRepository::class)->find($variety);
        }

        if (count($this->po) > 1) {
            foreach ($this->po as $po) {
                $this->pos [] = app(ProductRepository::class)->find($po);
            }
        }

        foreach ($this->eia as $eia) {
            $this->approval [] = app(ApprovalNumberRepository::class)->find($eia);
        }

        foreach ($this->cm as $cm) {
            $this->checkmark [] = app(CheckmarkRepository::class)->find($cm);
        }

        foreach ($this->bagcolor as $bagcolor) {
            $this->color [] = app(BagcolorRepository::class)->find($bagcolor);
        }

        foreach ($this->fm as $fm) {
            $this->fmcode [] = app(CodeMasterRepository::class)->find($fm);
        }

        foreach ($this->fr as $fr) {
            $this->frcode [] = app(CodeMasterRepository::class)->find($fr);
        }

        foreach ($this->d as $d) {
            $this->dcode [] = app(CodeMasterRepository::class)->find($d);
        }

        foreach ($this->s as $s) {
            $this->scode [] = app(CodeMasterRepository::class)->find($s);
        }

        foreach ($this->a as $a) {
            $this->acode [] = app(CodeMasterRepository::class)->find($a);
        }

        foreach ($this->c as $c) {
            $this->ccode [] = app(CodeMasterRepository::class)->find($c);
        }

        foreach ($this->p as $p) {
            $this->pcode [] = app(CodeMasterRepository::class)->find($p);
        }

        foreach ($this->b as $b) {
            $this->bcode [] = app(CodeMasterRepository::class)->find($b);
        }

        foreach ($this->m as $m) {
            $this->mcode [] = app(CodeMasterRepository::class)->find($m);
        }

        foreach ($this->w as $w) {
            $this->wcode [] = app(CodeMasterRepository::class)->find($w);
        }

        foreach ($this->q as $q) {
            $this->qcode [] = app(CodeMasterRepository::class)->find($q);
        }

        foreach ($this->sc as $sc) {
            $this->sccode [] = app(CodeMasterRepository::class)->find($sc);
        }

        foreach ($this->lc as $lc) {
            $this->lccode [] = app(CodeMasterRepository::class)->find($lc);
        }

        foreach ($this->i as $i) {
            $this->icode [] = app(CodeMasterRepository::class)->find($i);
        }

        foreach ($this->k as $k) {
            $this->kcode [] = app(CodeMasterRepository::class)->find($k);
        }

        foreach ($this->e as $e) {
            $this->ecode [] = app(CodeMasterRepository::class)->find($e);
        }

        foreach ($this->t as $t) {
            $this->tcode [] = app(CodeMasterRepository::class)->find($t);
        }

        foreach ($this->sg as $sg) {
            $this->sgcode [] = app(CodeMasterRepository::class)->find($sg);
        }

        foreach ($this->kg as $kg) {
            $this->kgcode [] = app(CodeMasterRepository::class)->find($kg);
        }

        foreach ($this->g as $g) {
            $this->gcode [] = app(CodeMasterRepository::class)->find($g);
        }

        foreach ($this->h as $h) {
            $this->hcode [] = app(CodeMasterRepository::class)->find($h);
        }

        foreach ($this->rc as $rc) {
            $this->rccode [] = app(CodeMasterRepository::class)->find($rc);
        }

        foreach ($this->mk as $mk) {
            $this->mkcode [] = app(CodeMasterRepository::class)->find($mk);
        }

        foreach ($this->v as $v) {
            $this->vcode [] = app(CodeMasterRepository::class)->find($v);
        }

        if ($this->reportDate == 0 && count($this->pos) > 1) {
            if (Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT)) {
                $this->date = 'Production Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT);
            } else {
                $this->date = 'Production From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Production To Date:' . Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT);
            }
            $queryBuilder = Product::with('user', 'buyer', 'cm', 'variety', 'bagColor', 'cartonType', 'fm', 'fr', 'd', 's', 'a', 'c', 'p', 'b', 'm', 'w', 'q', 'sc', 'lc', 'i', 'k', 'e', 't', 'sg', 'kg', 'g', 'h', 'rc', 'mk')
                ->whereIn('bag_color', $this->bagcolor, 'AND')
//                    ->whereIn('buyercode_id', $this->buyer,'AND')
                ->whereIn('fm_id', $this->fm, 'AND')
                ->whereIn('d_id', $this->d, 'AND')
                ->whereIn('s_id', $this->s, 'AND')
                ->whereIn('a_id', $this->a, 'AND')
                ->whereIn('c_id', $this->c, 'AND')
                ->whereIn('p_id', $this->p, 'AND')
                ->whereIn('b_id', $this->b, 'AND')
                ->whereIn('m_id', $this->m, 'AND')
                ->whereIn('w_id', $this->w, 'AND')
                ->whereIn('q_id', $this->q, 'AND')
                ->whereIn('sc_id', $this->sc, 'AND')
                ->whereIn('lc_id', $this->lc, 'AND')
                ->whereIn('fr_id', $this->fr, 'AND')
                ->whereIn('i_id', $this->i, 'AND')
                ->whereIn('k_id', $this->k, 'AND')
                ->whereIn('e_id', $this->e, 'AND')
                ->whereIn('t_id', $this->t, 'AND')
                ->whereIn('sg_id', $this->sg, 'AND')
                ->whereIn('kg_id', $this->kg, 'AND')
                ->whereIn('g_id', $this->g, 'AND')
                ->whereIn('h_id', $this->h, 'AND')
                ->whereIn('rc_id', $this->rc, 'AND')
                ->whereIn('mk_id', $this->mk, 'AND')
                ->whereIn('v_id', $this->v, 'AND')
                ->whereIn('cm_id', $this->cm, 'AND')
                ->where('status','active')
                ->whereIn('approval_no', $this->eia, 'AND')
                ->whereIn('fish_type', $this->variety, 'AND')
                ->whereIn('id', $this->po, 'AND')
                ->whereDate('product_date', '>=', $this->startDate)->whereDate('product_date', '<=', $this->endDate)->orderBy('product_date');
            $this->sum = app(ProductRepository::class)->allWithBuilder()
                ->whereIn('bag_color', $this->bagcolor, 'AND')
                ->whereIn('fm_id', $this->fm, 'AND')
                ->whereIn('d_id', $this->d, 'AND')
                ->whereIn('s_id', $this->s, 'AND')
                ->whereIn('a_id', $this->a, 'AND')
                ->whereIn('c_id', $this->c, 'AND')
                ->whereIn('p_id', $this->p, 'AND')
                ->whereIn('b_id', $this->b, 'AND')
                ->whereIn('m_id', $this->m, 'AND')
                ->whereIn('w_id', $this->w, 'AND')
                ->whereIn('q_id', $this->q, 'AND')
                ->whereIn('sc_id', $this->sc, 'AND')
                ->whereIn('lc_id', $this->lc, 'AND')
                ->whereIn('fr_id', $this->fr, 'AND')
                ->whereIn('i_id', $this->i, 'AND')
                ->whereIn('k_id', $this->k, 'AND')
                ->whereIn('e_id', $this->e, 'AND')
                ->whereIn('t_id', $this->t, 'AND')
                ->whereIn('sg_id', $this->sg, 'AND')
                ->whereIn('kg_id', $this->kg, 'AND')
                ->whereIn('g_id', $this->g, 'AND')
                ->whereIn('h_id', $this->h, 'AND')
                ->whereIn('rc_id', $this->rc, 'AND')
                ->whereIn('mk_id', $this->mk, 'AND')
                ->whereIn('v_id', $this->v, 'AND')
                ->whereIn('fish_type', $this->variety, 'AND')
                ->whereIn('cm_id', $this->cm, 'AND')
                ->whereIn('approval_no', $this->eia, 'AND')
                ->whereIn('id', $this->po, 'AND')
                ->where('status','active')
                ->whereDate('product_date', '>=', $this->startDate)
                ->whereDate('product_date', '<=', $this->endDate)
                ->sum('no_of_cartons');

            $this->reportMaster->subfooter = $this->sum;

        } elseif ($this->reportDate == 1 && count($this->pos) > 1) {
            if (Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT)) {
                $this->date = 'Carton Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT);
            } else {
                $this->date = 'Carton From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Carton To Date:' . Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT);
            }
            $queryBuilder = Product::with('user', 'buyer', 'cm', 'variety', 'bagColor', 'cartonType', 'fm', 'fr', 'd', 's', 'a', 'c', 'p', 'b', 'm', 'w', 'q', 'sc', 'lc', 'i', 'k', 'e', 't', 'sg', 'kg', 'g', 'h', 'rc', 'mk')
                ->whereIn('bag_color', $this->bagcolor, 'AND')
//                    ->whereIn('buyercode_id', $this->buyer,'AND')
                ->whereIn('fm_id', $this->fm, 'AND')
                ->whereIn('d_id', $this->d, 'AND')
                ->whereIn('s_id', $this->s, 'AND')
                ->whereIn('a_id', $this->a, 'AND')
                ->whereIn('c_id', $this->c, 'AND')
                ->whereIn('p_id', $this->p, 'AND')
                ->whereIn('b_id', $this->b, 'AND')
                ->whereIn('m_id', $this->m, 'AND')
                ->whereIn('w_id', $this->w, 'AND')
                ->whereIn('q_id', $this->q, 'AND')
                ->whereIn('sc_id', $this->sc, 'AND')
                ->whereIn('lc_id', $this->lc, 'AND')
                ->whereIn('fr_id', $this->fr, 'AND')
                ->whereIn('i_id', $this->i, 'AND')
                ->whereIn('k_id', $this->k, 'AND')
                ->whereIn('e_id', $this->e, 'AND')
                ->whereIn('t_id', $this->t, 'AND')
                ->whereIn('sg_id', $this->sg, 'AND')
                ->whereIn('kg_id', $this->kg, 'AND')
                ->whereIn('g_id', $this->g, 'AND')
                ->whereIn('h_id', $this->h, 'AND')
                ->whereIn('rc_id', $this->rc, 'AND')
                ->whereIn('mk_id', $this->mk, 'AND')
                ->whereIn('v_id', $this->v, 'AND')
                ->whereIn('fish_type', $this->variety, 'AND')
                ->whereIn('cm_id', $this->cm, 'AND')
                ->whereIn('approval_no', $this->eia, 'AND')
                ->whereIn('id', $this->po, 'AND')
                ->where('status','active')
                ->whereDate('carton_date', '>=', $this->startDate)->whereDate('carton_date', '<=', $this->endDate)->orderBy('lot_no');
            $this->sum = app(ProductRepository::class)->allWithBuilder()
                ->whereIn('bag_color', $this->bagcolor, 'AND')
//                    ->whereIn('buyercode_id', $this->buyer,'AND')
                ->whereIn('fm_id', $this->fm, 'AND')
                ->whereIn('d_id', $this->d, 'AND')
                ->whereIn('s_id', $this->s, 'AND')
                ->whereIn('a_id', $this->a, 'AND')
                ->whereIn('c_id', $this->c, 'AND')
                ->whereIn('p_id', $this->p, 'AND')
                ->whereIn('b_id', $this->b, 'AND')
                ->whereIn('m_id', $this->m, 'AND')
                ->whereIn('w_id', $this->w, 'AND')
                ->whereIn('q_id', $this->q, 'AND')
                ->whereIn('sc_id', $this->sc, 'AND')
                ->whereIn('lc_id', $this->lc, 'AND')
                ->whereIn('fr_id', $this->fr, 'AND')
                ->whereIn('i_id', $this->i, 'AND')
                ->whereIn('k_id', $this->k, 'AND')
                ->whereIn('e_id', $this->e, 'AND')
                ->whereIn('t_id', $this->t, 'AND')
                ->whereIn('sg_id', $this->sg, 'AND')
                ->whereIn('kg_id', $this->kg, 'AND')
                ->whereIn('g_id', $this->g, 'AND')
                ->whereIn('h_id', $this->h, 'AND')
                ->whereIn('rc_id', $this->rc, 'AND')
                ->whereIn('mk_id', $this->mk, 'AND')
                ->whereIn('v_id', $this->v, 'AND')
                ->whereIn('fish_type', $this->variety, 'AND')
                ->whereIn('cm_id', $this->cm, 'AND')
                ->whereIn('approval_no', $this->eia, 'AND')
                ->whereIn('id', $this->po, 'AND')
                ->where('status','active')
                ->whereDate('carton_date', '>=', $this->startDate)
                ->whereDate('carton_date', '<=', $this->endDate)
                ->sum('no_of_cartons');
            $this->reportMaster->subfooter = $this->sum;
        } elseif ($this->reportDate == 1) {
            if (Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT)) {
                $this->date = 'Carton Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT);
            } else {
                $this->date = 'Carton From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Carton To Date:' . Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT);
            }
            $queryBuilder = Product::with('user', 'buyer', 'cm', 'variety', 'bagColor', 'cartonType', 'fm', 'fr', 'd', 's', 'a', 'c', 'p', 'b', 'm', 'w', 'q', 'sc', 'lc', 'i', 'k', 'e', 't', 'sg', 'kg', 'g', 'h', 'rc', 'mk')
                ->whereIn('bag_color', $this->bagcolor, 'AND')
//                    ->whereIn('buyercode_id', $this->buyer,'AND')
                ->whereIn('fm_id', $this->fm, 'AND')
                ->whereIn('d_id', $this->d, 'AND')
                ->whereIn('s_id', $this->s, 'AND')
                ->whereIn('a_id', $this->a, 'AND')
                ->whereIn('c_id', $this->c, 'AND')
                ->whereIn('p_id', $this->p, 'AND')
                ->whereIn('b_id', $this->b, 'AND')
                ->whereIn('m_id', $this->m, 'AND')
                ->whereIn('w_id', $this->w, 'AND')
                ->whereIn('q_id', $this->q, 'AND')
                ->whereIn('sc_id', $this->sc, 'AND')
                ->whereIn('lc_id', $this->lc, 'AND')
                ->whereIn('fr_id', $this->fr, 'AND')
                ->whereIn('i_id', $this->i, 'AND')
                ->whereIn('k_id', $this->k, 'AND')
                ->whereIn('e_id', $this->e, 'AND')
                ->whereIn('t_id', $this->t, 'AND')
                ->whereIn('sg_id', $this->sg, 'AND')
                ->whereIn('kg_id', $this->kg, 'AND')
                ->whereIn('g_id', $this->g, 'AND')
                ->whereIn('h_id', $this->h, 'AND')
                ->whereIn('rc_id', $this->rc, 'AND')
                ->whereIn('mk_id', $this->mk, 'AND')
                ->whereIn('v_id', $this->v, 'AND')
                ->whereIn('fish_type', $this->variety, 'AND')
                ->whereIn('cm_id', $this->cm, 'AND')
                ->whereIn('approval_no', $this->eia, 'AND')
                ->where('status','active')
                ->whereDate('carton_date', '>=', $this->startDate)->whereDate('carton_date', '<=', $this->endDate)->orderBy('lot_no');
            $this->sum = app(ProductRepository::class)->allWithBuilder()
                ->whereIn('bag_color', $this->bagcolor, 'AND')
//                    ->whereIn('buyercode_id', $this->buyer,'AND')
                ->whereIn('fm_id', $this->fm, 'AND')
                ->whereIn('d_id', $this->d, 'AND')
                ->whereIn('s_id', $this->s, 'AND')
                ->whereIn('a_id', $this->a, 'AND')
                ->whereIn('c_id', $this->c, 'AND')
                ->whereIn('p_id', $this->p, 'AND')
                ->whereIn('b_id', $this->b, 'AND')
                ->whereIn('m_id', $this->m, 'AND')
                ->whereIn('w_id', $this->w, 'AND')
                ->whereIn('q_id', $this->q, 'AND')
                ->whereIn('sc_id', $this->sc, 'AND')
                ->whereIn('lc_id', $this->lc, 'AND')
                ->whereIn('fr_id', $this->fr, 'AND')
                ->whereIn('i_id', $this->i, 'AND')
                ->whereIn('k_id', $this->k, 'AND')
                ->whereIn('e_id', $this->e, 'AND')
                ->whereIn('t_id', $this->t, 'AND')
                ->whereIn('sg_id', $this->sg, 'AND')
                ->whereIn('kg_id', $this->kg, 'AND')
                ->whereIn('g_id', $this->g, 'AND')
                ->whereIn('h_id', $this->h, 'AND')
                ->whereIn('rc_id', $this->rc, 'AND')
                ->whereIn('mk_id', $this->mk, 'AND')
                ->whereIn('v_id', $this->v, 'AND')
                ->whereIn('fish_type', $this->variety, 'AND')
                ->whereIn('cm_id', $this->cm, 'AND')
                ->whereIn('approval_no', $this->eia, 'AND')
                ->where('status','active')
                ->whereDate('carton_date', '>=', $this->startDate)
                ->whereDate('carton_date', '<=', $this->endDate)
                ->sum('no_of_cartons');
            $this->reportMaster->subfooter = $this->sum;
        } elseif ($this->reportDate == 0) {
            if (Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) == Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT)) {
                $this->date = 'Production Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT);
            } else {
                $this->date = 'Production From Date: ' . Carbon::parse($this->startDate)->format(PHP_DATE_FORMAT) . '____Production To Date:' . Carbon::parse($this->endDate)->format(PHP_DATE_FORMAT);
            }
            $queryBuilder = Product::with('user', 'buyer', 'cm', 'variety', 'bagColor', 'cartonType', 'fm', 'fr', 'd', 's', 'a', 'c', 'p', 'b', 'm', 'w', 'q', 'sc', 'lc', 'i', 'k', 'e', 't', 'sg', 'kg', 'g', 'h', 'rc', 'mk')
                ->whereIn('bag_color', $this->bagcolor, 'AND')
//                    ->whereIn('buyercode_id', $this->buyer,'AND')
                ->whereIn('fm_id', $this->fm, 'AND')
                ->whereIn('d_id', $this->d, 'AND')
                ->whereIn('s_id', $this->s, 'AND')
                ->whereIn('a_id', $this->a, 'AND')
                ->whereIn('c_id', $this->c, 'AND')
                ->whereIn('p_id', $this->p, 'AND')
                ->whereIn('b_id', $this->b, 'AND')
                ->whereIn('m_id', $this->m, 'AND')
                ->whereIn('w_id', $this->w, 'AND')
                ->whereIn('q_id', $this->q, 'AND')
                ->whereIn('sc_id', $this->sc, 'AND')
                ->whereIn('lc_id', $this->lc, 'AND')
                ->whereIn('fr_id', $this->fr, 'AND')
                ->whereIn('i_id', $this->i, 'AND')
                ->whereIn('k_id', $this->k, 'AND')
                ->whereIn('e_id', $this->e, 'AND')
                ->whereIn('t_id', $this->t, 'AND')
                ->whereIn('sg_id', $this->sg, 'AND')
                ->whereIn('kg_id', $this->kg, 'AND')
                ->whereIn('g_id', $this->g, 'AND')
                ->whereIn('h_id', $this->h, 'AND')
                ->whereIn('rc_id', $this->rc, 'AND')
                ->whereIn('mk_id', $this->mk, 'AND')
                ->whereIn('v_id', $this->v, 'AND')
                ->whereIn('cm_id', $this->cm, 'AND')
                ->where('status','active')
                ->whereIn('approval_no', $this->eia, 'AND')
                ->whereIn('fish_type', $this->variety, 'AND')
                ->whereDate('product_date', '>=', $this->startDate)->whereDate('product_date', '<=', $this->endDate)->orderBy('product_date');
            $this->sum = app(ProductRepository::class)->allWithBuilder()
                ->whereIn('bag_color', $this->bagcolor, 'AND')
                ->whereIn('fm_id', $this->fm, 'AND')
                ->whereIn('d_id', $this->d, 'AND')
                ->whereIn('s_id', $this->s, 'AND')
                ->whereIn('a_id', $this->a, 'AND')
                ->whereIn('c_id', $this->c, 'AND')
                ->whereIn('p_id', $this->p, 'AND')
                ->whereIn('b_id', $this->b, 'AND')
                ->whereIn('m_id', $this->m, 'AND')
                ->whereIn('w_id', $this->w, 'AND')
                ->whereIn('q_id', $this->q, 'AND')
                ->whereIn('sc_id', $this->sc, 'AND')
                ->whereIn('lc_id', $this->lc, 'AND')
                ->whereIn('fr_id', $this->fr, 'AND')
                ->whereIn('i_id', $this->i, 'AND')
                ->whereIn('k_id', $this->k, 'AND')
                ->whereIn('e_id', $this->e, 'AND')
                ->whereIn('t_id', $this->t, 'AND')
                ->whereIn('sg_id', $this->sg, 'AND')
                ->whereIn('kg_id', $this->kg, 'AND')
                ->whereIn('g_id', $this->g, 'AND')
                ->whereIn('h_id', $this->h, 'AND')
                ->whereIn('rc_id', $this->rc, 'AND')
                ->whereIn('mk_id', $this->mk, 'AND')
                ->whereIn('v_id', $this->v, 'AND')
                ->where('status','active')
                ->whereIn('fish_type', $this->variety, 'AND')
                ->whereIn('cm_id', $this->cm, 'AND')
                ->whereIn('approval_no', $this->eia, 'AND')
                ->whereDate('product_date', '>=', $this->startDate)
                ->whereDate('product_date', '<=', $this->endDate)
                ->sum('no_of_cartons');
            $this->reportMaster->subfooter = $this->sum;
        }
        else
        {
            return "Please Apply Filter";
        }
        $this->data = $queryBuilder->get();
        $this->setupDone = true;

    }
}