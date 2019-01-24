<?php

namespace Modules\Reports\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Libraries\Utils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\BuyercodeRepository;
use Modules\Admin\Repositories\FishTypeRepository;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Repositories\InternalcodeRepository;
use Modules\Admin\Repositories\LocationRepository;
use Modules\Page\Repositories\PageRepository;
use Modules\Process\Entities\Transfer;
use Modules\Process\Repositories\ProductRepository;
use Modules\Process\Repositories\TransferRepository;
use Modules\Reports\Entities\ReportLog;
use Modules\Reports\Entities\ReportMaster;
use Modules\Reports\Http\Requests\CreateReportLogRequest;
use Modules\Reports\Http\Requests\UpdateReportLogRequest;
use Modules\Reports\Repositories\ReportLogRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Reports\Repositories\ReportMasterRepository;
use Modules\Reports\Repositories\ReportModuleRepository;
use Modules\Reports\Repositories\ReportParameterRepository;
use Str;
use PDF;

class ReportLogController extends AdminBaseController
{
    /**
     * @var ReportLogRepository
     */
    private $reportlog;

    /**
     * @var ReportMasterRepository
     */
    private $reportMaster;

    public function __construct(ReportLogRepository $reportlog,ReportMasterRepository $reportMaster)
    {
        parent::__construct();

        $this->reportlog = $reportlog;
        $this->reportMaster = $reportMaster;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($module)
    {
        $reports = $this->reportMaster->allWithBuilder()
            ->where('module_id','=',$module)
            ->pluck('name','id');

        $reportMasters = $this->reportMaster->all()->sortBy("template_file_id");

        $grade = app(GradeRepository::class)->allWithBuilder()
            ->orderBy('grade')
            ->pluck('grade','id');

        $variety = app(FishTypeRepository::class)->allWithBuilder()
            ->orderBy('type')
            ->pluck('type','id');

        $buyercode = app(BuyercodeRepository::class)->allWithBuilder()
            ->orderBy('buyer_code')
            ->pluck('buyer_code','id');
        
        $place = app(LocationRepository::class)->allWithBuilder()
            ->orderBy('location')
            ->pluck('location','id');
        
        $po = app(ProductRepository::class)->all();
        
        $transferData = app(TransferRepository::class)->all();

//        $orders= DB::table('process__shipments','process__shipments')
//            ->select(DB::raw('process__shipments.vehicle_no','process__transfers.vehicle_no'))
//            ->get();

        $shipmentVehicle =DB::table('process__shipments')
            ->distinct()
            ->select('vehicle_no');

        $vehicle = DB::table('process__transfers')
            ->distinct()
            ->select('vehicle_no')
            ->union($shipmentVehicle)
            ->get();

        $shipmentContainer =DB::table('process__shipments')
            ->distinct()
            ->select('container_no');

        $container = DB::table('process__transfers')
            ->distinct()
            ->select('container_no')
            ->union($shipmentContainer)
            ->get();

        $ic = app(InternalcodeRepository::class)->allWithBuilder()
            ->orderBy('internal_code')
            ->pluck('internal_code','id');
        
        return view('reports::admin.reportlogs.index', compact('reports','grade','variety','buyercode','po','ic','transferData','vehicle','container','place','reportMasters'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('reports::admin.reportlogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateReportLogRequest $request
     * @return Response
     */
    public function store(CreateReportLogRequest $request)
    {
        $this->reportlog->create($request->all());

        return redirect()->route('admin.reports.reportlog.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('reports::reportlogs.title.reportlogs')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ReportLog $reportlog
     * @return Response
     */
    public function edit(ReportMaster $reportlog)
    {
        return view('reports::admin.reportlogs.edit', compact('reportlog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ReportLog $reportlog
     * @param  UpdateReportLogRequest $request
     * @return Response
     */
    public function update(ReportLog $reportlog, UpdateReportLogRequest $request)
    {
        $this->reportlog->update($reportlog, $request->all());

        return redirect()->route('admin.reports.reportlog.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('reports::reportlogs.title.reportlogs')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReportLog $reportlog
     * @return Response
     */
    public function destroy(ReportLog $reportlog)
    {
        $this->reportlog->destroy($reportlog);

        return redirect()->route('admin.reports.reportlog.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('reports::reportlogs.title.reportlogs')]));
    }

    /**
     * Generate new report
     *
     * @param Request $request
     * @return mixed
     */
    public function generate(Request $request)
    {
        $reportType = app(ReportMasterRepository::class)->find($request->input('report_Type'));
        $reportClass = 'Modules\\Reports\\Reports\\'.Str::studly($reportType->class).'Report';
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $reportDate = $request->report_date;
        $buyercode = $request->buyer;
        $grade = $request->grade;
        $variety = $request->variety;
        $po = $request->po;
        $shipmentpo = $request->shipmentpo;
        $ic = $request->ic;
        $vehicle = $request->vehicle;
        $container = $request->container;
        $containerno = $request->container_id;
        $place = $request->place;
        $bagcolor = $request->bagcolor;
        $eia = $request->eia;
        $cm = $request->cm;
        $fm = $request->fm;
        $d = $request->d;
        $s = $request->s;
        $a = $request->a;
        $c = $request->c;
        $p = $request->p;
        $b = $request->b;
        $m = $request->m;
        $w = $request->w;
        $q = $request->q;
        $sc = $request->sc;
        $lc = $request->lc;
        $i = $request->i;
        $k = $request->k;
        $e = $request->e;
        $t = $request->t;
        $sg = $request->sg;
        $kg = $request->kg;
        $g = $request->g;
        $h = $request->h;
        $rc = $request->rc;
        $mk = $request->mk;
        $fr = $request->fr;
        $v = $request->v;

        $lastlot = app(ProductRepository::class)->allWithBuilder()
            ->whereDate('created_at' , '>=' , $startDate->format('Y-m-d'))
            ->whereDate('created_at' , '<=' , $endDate->format('Y-m-d'))
            ->orderBy('lot_no','desc')
            ->pluck('lot_no','id')
            ->first();
        
        $report = new $reportClass($reportType,$startDate,$endDate,$reportDate,$lastlot,$buyercode,$grade,$variety,$po,$ic,$vehicle,$container,$place,$bagcolor,$fm,$d,$s,$a,$c,$p,$b,$m,$w,$q,$sc,$lc,$i,$k,$e,$t,$sg,$kg,$g,$h,$rc,$mk,$eia,$cm,$shipmentpo,$containerno,$fr,$v,true);
        
        return  $report->viewPDF();
//        return view('reports::reports.dailyproduction' ,compact('report'));
    }


//    public function filter(ReportLog $reportlog)
//    {
//        return view('reports::admin.reportlogs.filters');
//    }
}
