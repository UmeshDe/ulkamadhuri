@extends('reports::reports.layout.master')

@section('styles')

    <?php
    use Dompdf\FontMetrics;
    use Carbon\Carbon;
    ?>
@endsection

@section('content')
    <?php

    $fishtypes = app(\Modules\Admin\Repositories\FishTypeRepository::class);
    ?>

    <table style="margin-top: 5%">
        {{--<thead>--}}
        <tr>
            <th colspan="23" align="center">
                {{$report->reportMaster->title}}
            </th>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>Stock On Date </strong>
            </td>
            <td style="text-align: left" colspan="22">
               {{Carbon::now()->format(PHP_DATE_FORMAT)}}
            </td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>Variety </strong>
            </td>
            <td style="text-align: left" colspan="22">
                @foreach($report->types as $type)
                    {{$type->type}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"> <strong>Place</strong>
            </td>
            <td colspan="22" align="left">
                @foreach($report->locations as $place)
                    {{$place->location}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>EIA No </strong>
            </td>
            <td style="text-align: left" colspan="22">
                @foreach($report->approval as $approval)
                    {{$approval->app_number}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>CM </strong>
            </td>
            <td style="text-align: left" colspan="22">
                @foreach($report->checkmark as $checkmark)
                    {{$checkmark->cm}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> Bag Color </strong>
            </td>
            <td colspan="22"
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
            {{--<td colspan="18"--}}
                {{--align="left">--}}
            {{--</td>--}}
        {{--</tr>--}}
        <tr>
            <td colspan="1"
                align="left"><strong> FM Code </strong>
            </td>
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            <td colspan="22"
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
            {{--<td colspan="18"--}}
                {{--align="left">--}}
                {{--@foreach($report->buyercode as $buyer)--}}
                    {{--{{$buyer->buyer_code}} ,--}}
                {{--@endforeach--}}
            {{--</td>--}}
        {{--</tr>--}}
        <tr>
            <th style="text-align: center">
                SPP
            </th>
                    @foreach ($report->grades->reverse() as $grade)
                        <th style="text-align: center">

                        {{  $grade->grade }}

                        </th>
                    @endforeach
            <th style="text-align: center">
                UG
            </th>
            <th style="text-align: center">
                Total
            </th>
        </tr>
        {{--</thead>--}}
        <?php
        $i = 0;
            $total = 0;
            $final = 0;
        ?>
        @foreach ($report->fishTypes as $fishtype)
            <?php
            $total = 0;
                $cartons = 0;
                    ?>
            <tr>
                <td style="text-align: center">
                    {{ $fishtype->type }}
                </td>
                @foreach ($report->grades->reverse() as $grade)
                    <td style="text-align: center">
                        <?php
                        $value = $report->gradeSum->where('grade_id', $grade->id)->where('fish_type', $fishtype->id);
                        if(count($value) >= 1)
                            {
                             foreach ($value as $val)
                                 {
                                     $total += $val->total_sales;
                                     echo $val->total_sales;
                                 }
                            }
                            else{
                            echo "";
                        }
                        ?>
                    </td>
                @endforeach
                <td style="text-align: center">
                    <?php
                    $value = $report->ungraded->where('fish_type', $fishtype->id);
                    foreach ($value as $val)
                    {
                        $cartons += $val->total_sales;
                        echo $cartons;
                        }
                        ?>
                </td>
                <th style="text-align: center">
                    <?php
                    echo $total + $cartons;
                    ?>
                </th>
            </tr>
        @endforeach

        <tr>
            <th style="text-align: center">Total</th>
            @foreach ($report->grades->reverse() as $grade)
            <th style="text-align: center">
                <?php
                $gradewiseTotal = 0;

                $value = $report->gradeSum->where('grade_id', $grade->id);
//                echo $value;
                    foreach ($value as $val)
                    {
                        $gradewiseTotal += $val->total_sales;
                    }
                    echo $gradewiseTotal;
                ?>
            </th>
            @endforeach
            <th style="text-align: center">
                <?php

                foreach ($report->ungraded as $val)
                {
                    $cartons += $val->total_sales;

                }
                echo $cartons;
                ?>

            </th>
            <?php
            foreach($report->gradeSum as $grade)
            {
                $final += $grade->total_sales;
            }
                    ?>
            <th style="text-align: center">
                <?php
                    echo $final + $cartons;
                ?>
            </th>

        </tr>

    </table>
@endsection

@section('script')


@endsection