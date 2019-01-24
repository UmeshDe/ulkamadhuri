<div class="box-body">
    <div class="box-header">
        Generate Report
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                {!!
                Former::select('report_Type')->label('Report type')
                ->fromQuery($reports,'name','id')
                !!}
            </div>
        </div>
        <div class="row">
            {{--<div class="col-md-12">--}}
                {{--{!!--}}
                {{--Former::radios('report_date')->label(null)--}}
                {{--->radios(['0' => 'Production Date' ,'1' => 'Carton Date','2' => 'Inspection Date','3' => 'Transfer Date','4' => 'Repacking Date','5' => 'Thowing Date' ])--}}
                {{--->inline()--}}
                {{--!!}--}}
            {{--</div>--}}
            <div class="col-md-3">
                {{--<div class="form-group">--}}
                <label for="report_Type">
                    Date.
                </label>
                <div class=" form-group has-feedback {{ $errors->has('report_date') ? ' has-error has-feedback' : '' }}">

                    {!! $errors->first('report_date', '<span class="help-block">:message</span>') !!}
                    <select class="select form-control" id="report_date" name="report_date">
                        @if($reportmaster->id == 3 || $reportmaster->id == 18 || $reportmaster->id == 20 || $reportmaster->id == 21 || $reportmaster->id == 23 || $reportmaster->id == 19 || $reportmaster->id == 35)
                            <option value="0">Production Date</option>
                            <option></option>
                        @endif
                        @if($reportmaster->id == 3 || $reportmaster->id == 35 || $reportmaster->id == 18 || $reportmaster->id == 20 || $reportmaster->id == 22 || $reportmaster->id == 21 || $reportmaster->id == 23 || $reportmaster->id == 19)
                            <option value="1">Carton Date</option>
                            <option></option>
                        @endif
                        @if($reportmaster->id == 11)
                            <option value="3">Transfer Date</option>
                            <option></option>
                        @endif
                        @if($reportmaster->id == 16)
                            <option value="5">Thowing Date</option>
                            <option></option>
                        @endif
                        @if($reportmaster->id == 20 || $reportmaster->id == 21 || $reportmaster->id == 14 || $reportmaster->id == 23)
                            <option value="2">Inspection Date</option>
                            <option></option>
                        @endif
                        @if($reportmaster->id == 13 || $reportmaster->id == 15)
                            <option value="6">Shipment Date</option>
                            <option></option>
                        @endif
                        @if($reportmaster->id == 26 || $reportmaster->id == 26)
                            <option value="4">Repacking Date</option>
                            <option></option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div id="date" class="form-group" hidden>
                    <label for="reportrange">
                        Date
                    </label>
                    <div>
                        <div id="reportrange" class="reportrange pull-right"
                             style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span></span> <b class="caret"></b>
                        </div>
                        <div style="display:none">
                            {!! Former::text('start_date')!!}
                            {!! Former::text('end_date') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="row">--}}
            {{--@if($reportmaster->id == 24)--}}
            {{--<div class="col-md-4">--}}
                {{--<div class="form-group">--}}
                    {{--<label for="report_Type" class="control-label col-lg-4 col-sm-4">--}}
                        {{--BuyerCode--}}
                    {{--</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--{!!--}}
                        {{--Former::select('buyer')->label('BuyerCode')--}}
                        {{--->addOption(null)--}}
                        {{--->fromQuery($buyercode,'buyer_code','id')--}}
                        {{--->addClass('select')--}}
                        {{--!!}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@endif--}}
        @if($reportmaster->id == 11 || $reportmaster->id == 17 || $reportmaster->id == 25)
            <div class="col-md-4">
                <div class="form-group">
                <label for="report_Type">
                    Vehicle No.
                </label>
                    <div class=" form-group has-feedback {{ $errors->has('vehicle_no') ? ' has-error has-feedback' : '' }}">

                        {!! $errors->first('vehicle_no', '<span class="help-block">:message</span>') !!}
                        <select class="select dropdown" id="vehicle-no" name="vehicle_no" multiple>
                            @foreach($vehicle as $data)
                                <option value="{{$data->vehicle_no}}">
                                    {{$data->vehicle_no}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif
        @if($reportmaster->id == 29)
                {{--<div class="col-md-3">--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="report_Type" class="control-label col-lg-4 col-sm-4">--}}
                            {{--IC--}}
                        {{--</label>--}}
                        <div class="col-md-4">
                            {!!
                            Former::select('ic')->label('IC')
                            ->multiple()
                            ->fromQuery($ic,'internal_code','id')
                            ->addClass('select')
                            ->select('1')
                            !!}
                        </div>
                    {{--</div>--}}
                {{--</div>--}}
        @endif

        {{--@if($reportmaster->id == 3)--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('fm_id')->label('FM')--}}
                  {{--->fromQuery($fm,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('d_id')->label('D')--}}
                  {{--->fromQuery($d,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('s_id')->label('S')--}}
                  {{--->fromQuery($s,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('a_id')->label('A')--}}
                  {{--->fromQuery($a,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('c_id')->label('C')--}}
                  {{--->fromQuery($c,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('p_id')->label('P')--}}
                  {{--->fromQuery($p,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('b_id')->label('B')--}}
                  {{--->fromQuery($b,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('m_id')->label('M')--}}
                  {{--->fromQuery($m,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('w_id')->label('W')--}}
                  {{--->fromQuery($w,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('q_id')->label('Q')--}}
                  {{--->fromQuery($q,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('sc_id')->label('SC')--}}
                  {{--->fromQuery($sc,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--{!!--}}
                  {{--Former::select('lc_id')->label('LC')--}}
                  {{--->fromQuery($lc,'code','id')--}}
                  {{--->addOption(null)--}}
                  {{--->addClass('select')--}}
                  {{--->select('1')--}}
                {{--!!}--}}
            {{--</div>--}}
        {{--@endif--}}
        {{--@if($reportmaster->id == 29 )--}}
            {{--<div class="col-md-3">--}}
                {{--<div class="form-group">--}}
                {{--<label for="report_Type" class="control-label col-lg-4 col-sm-4">--}}
                {{--Place--}}
                {{--</label>--}}
                {{--<div class="col-lg-8 col-sm-8">--}}
                {{--{!!--}}
                {{--Former::select('place')--}}
                {{--->fromQuery($place,'location','id')--}}
                {{--->addClass('select')--}}
                {{--->multiple()--}}
                {{--->select('1')--}}

                {{--!!}--}}
                {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--@endif--}}
        @if($reportmaster->id == 24)

        <div class="col-md-4">
            {!!
            Former::select('buyer')->label('Buyer Code')
            ->fromQuery($buyercode,'buyer_code','id')
            ->addClass('select')
            ->multiple()
            ->select('1')
            !!}
        </div>

        @endif
        @if($reportmaster->id == 30 || $reportmaster->id == 31 || $reportmaster->id == 32 || $reportmaster->id == 27)
            <div class="col-md-4">
                {!!
             Former::select('invoice_id')->label('PO No.')
             ->addOption(null)
             ->fromQuery($invoiceno,'invoice_no','id')
             ->addClass('select')
             !!}
            </div>
            <div class="col-md-4">
                {!!
             Former::select('container_id')->label('Container No')
             ->addClass('select')
             !!}
            </div>
        @endif

        @if($reportmaster->id == 11 || $reportmaster->id == 17 || $reportmaster->id == 24 || $reportmaster->id == 25)
            <div class="col-md-4">
                <div class="form-group">
                    <label for="report_Type">
                        Container No.
                    </label>
                    <div class=" form-group has-feedback {{ $errors->has('container_no') ? ' has-error has-feedback' : '' }}">
                        {!! $errors->first('container_no', '<span class="help-block">:message</span>') !!}
                        <select class="select dropdown" id="container-no" name="container_no" multiple>
                            @foreach($container as $data)
                                <option value="{{$data->container_no}}">
                                    {{$data->container_no}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif


        @if($reportmaster->id == 28 || $reportmaster->id == 35)
        <div class="col-md-4">
            {!!
            Former::select('place')
            ->fromQuery($place,'location','id')
            ->addClass('select')
            ->multiple()
            ->select('1')
            !!}
        </div>
        @endif
        @if($reportmaster->id == 22 || $reportmaster->id == 28 || $reportmaster->id == 35 || $reportmaster->id == 3 || $reportmaster->id == 18)
            <div class="col-md-4">
                {{--<div class="form-group">--}}
                {{--<label for="report_Type" class="control-label col-lg-4 col-sm-4">--}}
                {{--Variety--}}
                {{--</label>--}}
                {{--<div class="col-lg-8 col-sm-8">--}}
                {!!
                Former::select('variety')
                ->multiple()
                ->fromQuery($variety,'type','id')
                ->addClass('select')
                ->select('1')
                !!}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        @endif
        @if($reportmaster->id == 28 || $reportmaster->id == 35 || $reportmaster->id == 3 || $reportmaster->id == 18)
            <div class="col-md-4">
                {!!
                  Former::select('eia_id')->label('EIA No')
                  ->fromQuery($eiano,'app_number','id')
                  ->addClass('select')
                  ->multiple()
                  ->selectAll()
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('cm_id')->label('CM')
                  ->fromQuery($cm,'cm','id')
                  ->addClass('select')
                  ->multiple()
                  ->selectAll()
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('bagcolor_id')->label('Bag Color')
                  ->fromQuery($bagColor,'color','id')
                  ->addClass('select')
                  ->multiple()
                  ->selectAll()
                !!}
            </div>


            <div class="col-md-4">
                {!!
                  Former::select('fm_id')->label('FM')
                  ->fromQuery($fm,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('i_id')->label('I')
                  ->fromQuery($i,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('k_id')->label('K')
                  ->fromQuery($k,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('e_id')->label('E')
                  ->fromQuery($e,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('t_id')->label('T')
                  ->fromQuery($t,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('sg_id')->label('SG')
                  ->fromQuery($sg,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('kg_id')->label('KG')
                  ->fromQuery($kg,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('g_id')->label('G')
                  ->fromQuery($g,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('h_id')->label('H')
                  ->fromQuery($h,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('rc_id')->label('RC')
                  ->fromQuery($rc,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('mk_id')->label('MK')
                  ->fromQuery($mk,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('d_id')->label('D')
                  ->fromQuery($d,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('s_id')->label('S')
                  ->fromQuery($s,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('a_id')->label('A')
                  ->fromQuery($a,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('c_id')->label('C')
                  ->fromQuery($c,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('p_id')->label('P')
                  ->fromQuery($p,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('b_id')->label('B')
                  ->fromQuery($b,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('m_id')->label('M')
                  ->fromQuery($m,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('w_id')->label('W')
                  ->fromQuery($w,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('q_id')->label('Q')
                  ->fromQuery($q,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('sc_id')->label('SC')
                  ->fromQuery($sc,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('lc_id')->label('LC')
                  ->fromQuery($lc,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('fr_id')->label('KT')
                  ->fromQuery($fr,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
            <div class="col-md-4">
                {!!
                  Former::select('v_id')->label('V')
                  ->fromQuery($v,'code','id')
                  ->multiple()
                  ->addClass('select')
                  ->select('1')
                !!}
            </div>
        @endif
        @if($reportmaster->id == 3)
            <div class="col-md-4">
                <div class="form-group">
                    @if($reportmaster->id == 27 )
                    <label for="report_Type">
                        Data From Production
                    </label>
                        @else
                        <label for="report_Type">
                            PO
                        </label>
                    @endif
                    <div class=" form-group has-feedback {{ $errors->has('po') ? ' has-error has-feedback' : '' }}">
                        {!! $errors->first('po', '<span class="help-block">:message</span>') !!}
                        <select class="select dropdown" id="po" name="po" multiple>
                            @foreach($po as $p)
                                {{--@if($p->po_mo !== NULL)--}}
                                <option value="{{$p->id}}">
                                    {{$p->po_no}}
                                </option>
                                {{--@endif--}}
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif

        @if($reportmaster->id == 25)

            <div class="col-md-4">
                <div class="form-group">
                        <label for="report_Type">
                           PO
                        </label>

                    <div class=" form-group has-feedback {{ $errors->has('shipmentpo') ? ' has-error has-feedback' : '' }}">
                        {!! $errors->first('shipmentpo', '<span class="help-block">:message</span>') !!}
                        <select class="select dropdown" id="shipmentpo" name="shipmentpo" multiple>
                                @foreach($shipmentpo as $item)
                                    @if($item->invoice_no !== NULL)
                                    <option value="{{$item->id}}">
                                        {{$item->invoice_no}}
                                    </option>
                                    @endif
                                @endforeach
                        </select>
                    </div>
                </div>
            </div>

        @endif



        @if($reportmaster->id == 35 || $reportmaster->id == 22)
        <div class="col-md-4">
                {!!
                Former::select('grade')
                ->multiple()
                ->fromQuery($grade,'grade','id')
                ->addClass('grade')
                ->select('1')
                !!}
        </div>
            @endif
        </div>
    </div>