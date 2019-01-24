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
            <div class="col-md-12">
                {!!
                Former::radios('report_date')->label('Date')
                ->radios(['0' => 'Production Date' ,'1' => 'Carton Date','2' => 'Inspection Date','3' => 'Transfer Date','4' => 'Repacking Date','5' => 'Thowing Date' ])
                ->inline()
                !!}
            </div>
            <div class="col-md-3">
                {{--<div class="form-group">--}}
                <label for="report_Type">
                    Date.
                </label>
                <div class=" form-group has-feedback {{ $errors->has('report_date') ? ' has-error has-feedback' : '' }}">

                    {!! $errors->first('report_date', '<span class="help-block">:message</span>') !!}
                    <select class="select dropdown" id="report_date" name="report_date">
                        <option></option>
                        @if()
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
        <div class="row">
            <div class="col-md-3">
                {{--<div class="form-group">--}}
                {{--<label for="report_Type" class="control-label col-lg-4 col-sm-4">--}}
                {{--BuyerCode--}}
                {{--</label>--}}
                {{--<div class="col-lg-8 col-sm-8">--}}
                {!!
                Former::select('buyer')
                ->addOption(null)
                ->fromQuery($buyercode,'buyer_code','id')

                !!}
                {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="col-md-3">
                {{--<div class="form-group">--}}
                <label for="report_Type">
                    Vehicle No.
                </label>
                <div class=" form-group has-feedback {{ $errors->has('vehicle_no') ? ' has-error has-feedback' : '' }}">

                    {!! $errors->first('vehicle_no', '<span class="help-block">:message</span>') !!}
                    <select class="select dropdown" id="vehicle-no" name="vehicle_no">
                        <option></option>
                        @foreach($vehicle as $data)
                            <option value="{{$data->vehicle_no}}">
                                {{$data->vehicle_no}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="report_Type">
                        Container No.
                    </label>
                    <div class=" form-group has-feedback {{ $errors->has('container_no') ? ' has-error has-feedback' : '' }}">
                        {!! $errors->first('container_no', '<span class="help-block">:message</span>') !!}
                        <select class="select dropdown" id="container-no" name="container_no">
                            <option></option>
                            @foreach($container as $data)
                                <option value="{{$data->container_no}}">
                                    {{$data->container_no}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                {{--<div class="form-group">--}}
                {{--<label for="report_Type" class="control-label col-lg-4 col-sm-4">--}}
                {{--Place--}}
                {{--</label>--}}
                {{--<div class="col-lg-8 col-sm-8">--}}
                {!!
                Former::select('place')
                ->addOption(null)
                ->fromQuery($place,'location','id')
                ->select('1')

                !!}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                {{--<div class="form-group">--}}
                {{--<label for="report_Type" class="control-label col-lg-4 col-sm-4">--}}
                {{--Grade--}}
                {{--</label>--}}
                {{--<div class="col-lg-8 col-sm-8">--}}
                {!!
                Former::select('grade')
                ->addOption(null)
                ->fromQuery($grade,'grade','id')
                ->select('1')

                !!}
                {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="col-md-3">
                {{--<div class="form-group">--}}
                {{--<label for="report_Type" class="control-label col-lg-4 col-sm-4">--}}
                {{--Variety--}}
                {{--</label>--}}
                {{--<div class="col-lg-8 col-sm-8">--}}
                {!!
                Former::select('variety')
                ->addOption(null)
                ->fromQuery($variety,'type','id')
                ->select('1')

                !!}
                {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="col-md-3">
                {{--<div class="form-group">--}}
                {{--<label for="report_Type" class="control-label col-lg-4 col-sm-4">--}}
                {{--IC--}}
                {{--</label>--}}
                {{--<div class="col-lg-8 col-sm-8">--}}
                {!!
                Former::select('ic')
                ->addOption(null)
                ->fromQuery($ic,'internal_code','id')
                ->select('1')

                !!}
                {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="report_Type">
                        PO
                    </label>
                    <div class=" form-group has-feedback {{ $errors->has('po') ? ' has-error has-feedback' : '' }}">
                        {!! $errors->first('po', '<span class="help-block">:message</span>') !!}
                        <select class="select dropdown" id="po" name="po">
                            <option></option>
                            @foreach($po as $p)
                                <option value="{{$p->po_no}}">
                                    {{$p->po_no}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>