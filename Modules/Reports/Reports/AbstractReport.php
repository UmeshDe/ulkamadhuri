<?php


namespace Modules\Reports\Reports;


use Carbon\Carbon;
use Modules\Reports\Entities\ReportMaster;
use PDF;

class AbstractReport
{

    public $startDate;
    public $endDate;
    public $reportDate;
    public $buyer;
    public $grade;
    public $variety;
    public $po;
    public $shipmentpo;
    public $ic;
    public $bagcolor;
    public $fm;
    public $d;
    public $s;
    public $a;
    public $c;
    public $p;
    public $b;
    public $m;
    public $w;
    public $q;
    public $sc;
    public $lc;
    public $fr;
    public $v;
    public $eia;
    public $cm;
    public $vehicle;
    public $containerno;
    public $container;
    public $place;
    public $gradesum;
    
    public $options;
    public $createdBy;
    
    
    public $defaultViewName = 'report';
    public $pageSize;
    public $pageOrientation;

    public $totals = [];
    public $columns = [];
    public $data;

    public $name;
    public $sum;
    public $lastlot;

    public $pdf;
    public $csv;

    public $setupDone;

    public $reportMaster;

    public function __construct(ReportMaster $reportMaster,$startDate, $endDate,$reportDate,$lastlot,$buyer,$grade,$variety,$po,$ic,$vehicle,$container,$place,$bagcolor,$fm,$d,$s,$a,$c,$p,$b,$m,$w,$q,$sc,$lc,$i,$k,$e,$t,$sg,$kg,$g,$h,$rc,$mk,$eia,$cm,$shipmentpo,$containerno,$fr,$v,$gradesum,$pageSize = null, $pageOrientation =null,$options = false)
    {
        $this->reportMaster = $reportMaster;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->reportDate = $reportDate;
        $this->options = $options;
        $this->lastlot = $lastlot;
        $this->buyer = $buyer;
        $this->grade = $grade;
        $this->variety = $variety;
        $this->po = $po;
        $this->shipmentpo = $shipmentpo;
        $this->ic = $ic;
        $this->vehicle = $vehicle;
        $this->container = $container;
        $this->place = $place;
        $this->bagcolor = $bagcolor;
        $this->fm = $fm;
        $this->d = $d;
        $this->s = $s;
        $this->a = $a;
        $this->c = $c;
        $this->p = $p;
        $this->b = $b;
        $this->m = $m;
        $this->w = $w;
        $this->q = $q;
        $this->sc = $sc;
        $this->lc = $lc;
        $this->i = $i;
        $this->k = $k;
        $this->e = $e;
        $this->t = $t;
        $this->sg = $sg;
        $this->kg = $kg;
        $this->g = $g;
        $this->h = $h;
        $this->rc = $rc;
        $this->mk = $mk;
        $this->eia = $eia;
        $this->fr = $fr;
        $this->v = $v;
        $this->cm = $cm;
        $this->containerno = $containerno;


        $this->gradesum = $gradesum;
     
        if($pageSize != null )
        {
            $this->reportMaster->papersize = $pageSize;   
        }
        if($pageOrientation != null)
        {
            $this->reportMaster->orientation = $pageOrientation;   
        }
        
        if($this->reportMaster->viewname == null || $this->reportMaster->viewname == "")
        {
            $this->reportMaster->viewname = $this->defaultViewName;
        }
    }

    public function setup(){

    }

    public function html(){
        if(!$this->setupDone){
            $this->setup();
        }
        return view('reports::reports.'.$this->reportMaster->viewname)->with('report',$this);
    }

    public function viewPDF(){

        if(!$this->setupDone){
            $this->setup();
        }

        $this->generatePDF();
//        return "hfd";

//        return $this->downloadPDF();
        return $this->pdf->stream();
    }

    public function generatePDF()
    {
        $this->pdf = PDF::loadView('reports::reports.'.$this->reportMaster->viewname,['report'=>$this])
            ->setPaper($this->reportMaster->papersize, $this->reportMaster->orientation);
    }

    public function downloadPDF(){
        if(!$this->setupDone){
            $this->setup();
        }

        $this->generatePDF();

        return $this->pdf->export();

    }

    public function downloadCSV(){

    }

    public function viewCSV(){

    }

    public function results()
    {
        return [
            'columns' => $this->columns,
            'displayData' => $this->data,
            'reportTotals' => $this->totals,
        ];
    }

    public function getReportName(){
        return  $this->name.'-'.$this->startDate.'-'.$this->endDate.'-'.Carbon::now()->toDateTimeString();
    }

}