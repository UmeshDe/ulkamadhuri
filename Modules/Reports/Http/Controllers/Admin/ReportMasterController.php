<?php

namespace Modules\Reports\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\BagcolorRepository;
use Modules\Admin\Repositories\BuyercodeRepository;
use Modules\Admin\Repositories\ApprovalNumberRepository;
use Modules\Admin\Repositories\CheckmarkRepository;
use Modules\Admin\Repositories\CodeMasterRepository;
use Modules\Admin\Repositories\FishTypeRepository;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Repositories\InternalcodeRepository;
use Modules\Admin\Repositories\LocationRepository;
use Modules\Process\Repositories\ProductRepository;
use Modules\Process\Repositories\ShipmentRepository;
use Modules\Process\Repositories\TransferRepository;
use Modules\Reports\Entities\ReportMaster;
use Modules\Reports\Http\Requests\CreateReportMasterRequest;
use Modules\Reports\Http\Requests\UpdateReportMasterRequest;
use Modules\Reports\Repositories\ReportMasterRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Reports\Repositories\ReportModuleRepository;
use Modules\User\Contracts\Authentication;

class ReportMasterController extends AdminBaseController
{
    /**
     * @var ReportMasterRepository
     */
    private $reportmaster;


    private $auth;

    public function __construct(ReportMasterRepository $reportmaster,Authentication $auth)
    {
        parent::__construct();

        $this->reportmaster = $reportmaster;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reportmasters = $this->reportmaster->all();
        $reportmodules = app(ReportModuleRepository::class)->all();
        return view('reports::admin.reportmasters.index', compact('reportmasters','reportmodules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('reports::admin.reportmasters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateReportMasterRequest $request
     * @return Response
     */
    public function store(CreateReportMasterRequest $request)
    {
        $this->reportmaster->create($request->all());

        return redirect()->route('admin.reports.reportmaster.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('reports::reportmasters.title.reportmasters')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ReportMaster $reportmaster
     * @return Response
     */
    public function edit(ReportMaster $reportmaster)
    {

        $codeMasterRepo = app(CodeMasterRepository::class);

        $reports = $this->reportmaster->allWithBuilder()
            ->where('module_id','=',$reportmaster->module_id)
            ->pluck('name','id');

        $reportLogs = app(ReportMasterRepository::class)->all();

        $grade = app(GradeRepository::class)->allWithBuilder()
            ->orderBy('grade')
            ->pluck('grade','id');

        $eiano = app(ApprovalNumberRepository::class)->allWithBuilder()
            ->orderBy('app_number')
            ->pluck('app_number','id');

        $cm = app(CheckmarkRepository::class)->allWithBuilder()
            ->orderBy('cm')
            ->pluck('cm','id');

        $variety = app(FishTypeRepository::class)->allWithBuilder()
            ->orderBy('type')
            ->pluck('type','id');

        $buyercode = app(BuyercodeRepository::class)->allWithBuilder()
            ->orderBy('buyer_code')
            ->pluck('buyer_code','id');

        $place = app(LocationRepository::class)->allWithBuilder()
            ->orderBy('location')
            ->pluck('location','id');

        $po = app(ProductRepository::class)->all()->where('po_no','!=',null);


        $shipmentpo = app(ShipmentRepository::class)->all()->where('invoice_no','!=',null);

        $bagColor = app(BagcolorRepository::class)->allWithBuilder()
            ->orderBy('color')
            ->pluck('color','id');


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


        $fm = $codeMasterRepo->allWithBuilder()
            ->where('is_parent' ,'=',1)
            ->orderBy('code')
            ->pluck('code','id');

        $d = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',3)
            ->orderBy('code')
            ->pluck('code','id');

        $s = $codeMasterRepo->allWithBuilder()
            ->where('is_parent' ,'=',4)
            ->orderBy('code')
            ->pluck('code','id');

        $a = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',5)
            ->orderBy('code')
            ->pluck('code','id');

        $c = $codeMasterRepo->allWithBuilder()
            ->where('is_parent' ,'=' ,6)
            ->orderBy('code')
            ->pluck('code','id');

        $p= $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',7)
            ->orderBy('code')
            ->pluck('code','id');

        $b= $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',8)
            ->orderBy('code')
            ->pluck('code','id');

        $m = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',9)
            ->orderBy('code')
            ->pluck('code','id');

        $w = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',10)
            ->orderBy('code')
            ->pluck('code','id');

        $q = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',11)
            ->orderBy('code')
            ->pluck('code','id');

        $sc = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',12)
            ->orderBy('code')
            ->pluck('code','id');

        $lc = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',13)
            ->orderBy('code')
            ->pluck('code','id');

        $i = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',245)
            ->orderBy('code')
            ->pluck('code','id');

        $k = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',268)
            ->orderBy('code')
            ->pluck('code','id');

        $e = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',277)
            ->orderBy('code')
            ->pluck('code','id');

        $t = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',278)
            ->orderBy('code')
            ->pluck('code','id');

        $sg = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',279)
            ->orderBy('code')
            ->pluck('code','id');

        //where is_parent == 280
        $kg = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',488)
            ->orderBy('code')
            ->pluck('code','id');

        $g = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',281)
            ->orderBy('code')
            ->pluck('code','id');

        $h = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',282)
            ->orderBy('code')
            ->pluck('code','id');

        $rc = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',284)
            ->orderBy('code')
            ->pluck('code','id');

        $mk = $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',285)
            ->orderBy('code')
            ->pluck('code','id');

        $fr = $codeMasterRepo->allWithBuilder()
            ->where('is_parent' ,'=',2)
            ->orderBy('code')
            ->pluck('code','id');

        $v =  $codeMasterRepo->allWithBuilder()
            ->where('is_parent','=',525)
            ->orderBy('code')
            ->pluck('code','id');

        $invoicenos = app(ShipmentRepository::class)->allWithBuilder()
            ->orderBy('invoice_no')
            ->pluck('invoice_no','id');

        $codes = [
            'fm' => $fm,
            'd' => $d,
            's' => $s,
            'a' => $a,
            'c' => $c,
            'p' => $p,
            'b' => $b,
            'm' => $m,
            'w' => $w,
            'q' => $q,
            'sc' => $sc,
            'lc' => $lc,
            'i' => $i,
            'k' => $k,
            'e' => $e,
            't' => $t,
            'sg' => $sg,
            'kg' => $kg,
            'g' => $g,
            'h' => $h,
            'rc' => $rc,
            'fr' => $fr,
            'mk' => $mk,
            'v' => $v,
            'invoiceno' => $invoicenos
        ];

        return view('reports::admin.reportmasters.edit', compact('reports','grade','variety','buyercode','po','ic','transferData','vehicle','container','place','reportLogs','reportmaster','bagColor','eiano','cm','shipmentpo'))->with($codes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ReportMaster $reportmaster
     * @param  UpdateReportMasterRequest $request
     * @return Response
     */
    public function update(ReportMaster $reportmaster, UpdateReportMasterRequest $request)
    {
        $reportmaster = $this->reportmaster->find($request->reportmaster_id);
        $this->reportmaster->update($reportmaster, $request->all());

        return redirect()->route('admin.reports.reportmaster.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('reports::reportmasters.title.reportmasters')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReportMaster $reportmaster
     * @return Response
     */
    public function destroy(ReportMaster $reportmaster)
    {
        $this->reportmaster->destroy($reportmaster);

        return redirect()->route('admin.reports.reportmaster.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('reports::reportmasters.title.reportmasters')]));
    }
}
