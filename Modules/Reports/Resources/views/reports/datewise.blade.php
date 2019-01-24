@extends('reports::reports.layout.master')

@section('styles')

    <?php
    use Dompdf\FontMetrics;
    ?>
@endsection

@section('content')

    <table class="export-table">
        <tr>
            <td colspan="10" align="center"> {{$report->reportMaster->title}}</td>
        </tr>
        <tr>
            <td colspan="10" align="left"> {{$report->date}}</td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>Variety </strong>
            </td>
            <td style="text-align: left" colspan="9">
                @foreach($report->types as $type)
                    {{$type->type}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>EIA No </strong>
            </td>
            <td style="text-align: left" colspan="9">
                @foreach($report->approval as $approval)
                    {{$approval->app_number}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>CM </strong>
            </td>
            <td style="text-align: left" colspan="9">
                @foreach($report->checkmark as $checkmark)
                    {{$checkmark->cm}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> Bag Color </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->color as $color)
                    {{$color->color}} ,
                @endforeach
            </td>
        </tr>
        {{--<tr>--}}
        {{--<td colspan="1"--}}
        {{--align="left"> <strong>PO No. </strong>--}}
        {{--</td>--}}
        {{--<td colspan="9"--}}
        {{--align="left">--}}
        {{--</td>--}}
        {{--</tr>--}}
        <tr>
            <td colspan="1"
                align="left"><strong> FM Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->fmcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> I Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->icode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> K Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->kcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> E Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->ecode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> T Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->tcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> SG Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->sgcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> KG Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->kgcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> G Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->gcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> H Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->hcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> RC Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->rccode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> MK Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->mkcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> D Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->dcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> S Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->scode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> A Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->acode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> C Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->ccode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> P Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->pcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> B Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->bcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> M Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->mcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> W Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->wcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> Q Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->qcode as $code)
                    {{$code->code}}
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> SC Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->sccode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> LC Code </strong>
            </td>
            <td colspan="9"
                align="left">
                @foreach($report->lccode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        {{--<tr>--}}
        {{--<td colspan="1"--}}
        {{--align="left"><strong> BuyerCode </strong>--}}
        {{--</td>--}}
        {{--<td colspan="9"--}}
        {{--align="left">--}}
        {{--@foreach($report->buyercode as $buyer)--}}
        {{--{{$buyer->buyer_code}} ,--}}
        {{--@endforeach--}}
        {{--</td>--}}
        {{--</tr>--}}
        <thead>
        <tr>
            @foreach($report->columns as $column)
                <th style="text-align: center">
                    {{isset($column['display_name'])?$column['display_name']:''}}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        ?>
        @foreach($report->data as $row)
            <tr>
                <td style="text-align: center">{{$i}}</td>
                <td style="text-align: center">
                    {{isset($row->product_date)?\Carbon\Carbon::parse($row->product_date)->format(PHP_DATE_FORMAT) : '' }}
                </td>
                <td style="text-align: center">
                    {{isset($row->carton_date)?\Carbon\Carbon::parse($row->carton_date)->format(PHP_DATE_FORMAT) : '' }}
                </td>
                <td style="text-align: center">{{ $row->type}}</td>
                <td style="text-align: center">{{$row->cm}}</td>
                <td style="text-align: center">{{$row->firstlot}}</td>
                <td style="text-align: center">{{$row->lastlot}}</td>
                <td style="text-align: center">{{$row->product_slab}}</td>
                <td style="text-align: center">{{$row->product_slab / 20}}</td>
                <td style="text-align: center">{{$row->remark}}</td>
            </tr>
            <?php $i++;
            ?>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="7" align="center"></td>
            <th colspan="1" style="text-align: center"> Total No. Of Cartons</th>
            <th style="text-align: center">{{$report->reportMaster->subfooter}}</th>
            <td colspan="1"></td>
        </tr>
        </tfoot>
    </table>
@endsection
