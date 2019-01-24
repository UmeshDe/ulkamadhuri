@extends('reports::reports.layout.master')
<?php  ini_set('max_execution_time', -1); ?>

@section('styles')

    <?php
    use Dompdf\FontMetrics;


    ?>

@endsection

@section('content')

    <style>
        table , th,td {
            border : 1px solid black;
        }
        tr:nth-child(even) {
            background-color: whitesmoke;
        }
        #heading {
            border: none;
        }
    </style>
            <h2 style="text-align: center">{{$report->reportMaster->title}}</h2>

    <br><br>
    <table>
        <tr>
            <th colspan="6"
                align="left"> <small>Container </small>
            </th>
            <td colspan="6" align="left">
                {{$report->containerno}}
            </td>
            <th colspan="5"
                align="left"> <small>Shipment Date  </small>
            </th>
            <td colspan="6" align="left">
                {{\Carbon\Carbon::parse($report->shipmentdata[0]->date)->format(PHP_DATE_FORMAT)}}
            </td>
        </tr>
        <tr>
            <th colspan="6"
                align="left"> <small>PO No. </small>
            </th>
            <td colspan="6" align="left">
                {{$report->shipmentdata[0]->invoice_no}}
            </td>
            <th colspan="5"
                align="left"> <small>Approval No.</small>
            </th>
            <td colspan="6" align="left">
                {{isset($report->shipmentdata[0]->approvalno) ? $report->shipmentdata[0]->approvalno->app_number : ''}}
            </td>
        </tr>
        <tr>
            <th colspan="6"
                align="left"> <small>Total Cartons</small>
            </th>
            <td colspan="6" align="left">
                @foreach($report->sum as $sum)
                    {{$sum->total}}
                @endforeach
            </td>
            <th colspan="5"
                align="left"> <small>Supervisor</small>
            </th>
            <td colspan="6" align="left">
                {{$report->shipmentdata[0]->supervisor->first_name}}
            </td>
        </tr>
        <tr>
            <th colspan="6"
                align="left"> <small>Vehicle No.</small>
            </th>
            <td colspan="6" align="left">
                {{$report->shipmentdata[0]->vehicle_no}}
            </td>
            <th colspan="5"
                align="left"> <small>Container Seal No.</small>
            </th>
            <td colspan="6" align="left">
                {{$report->shipmentdata[0]->seal_no}}
            </td>
        </tr>
        <tr>
            <th colspan="6"
                align="left"> <small>Temperature</small>
            </th>
            <td colspan="6" align="left">
                {{$report->shipmentdata[0]->temperature}}
            </td>
            <th colspan="5"
                align="left">
                <small>Stuffing Location</small>
            </th>
            <td colspan="6" align="left">
                @foreach($report->shipmentdata as $item)
                    {{$item->location->location}}
                @endforeach
            </td>
        </tr>
        <tr>
            <th colspan="6">
                <small>Variety</small>
            </th>
            <td colspan="6" align="left">
            <?php
                $uniques = [];
            ?>

            @foreach($report->shipmentdata as $shipmnet)
                    @foreach($shipmnet->shipmentcarton as $carton)
                        {{--{{$carton->carton->product->fishtype}},--}}

                    <?php
                        if(!in_array($carton->carton->product->fishtype, $uniques)){
                        $uniques[] = $carton->carton->product->fishtype;
                        echo $carton->carton->product->fishtype.',';
                        }
                    ?>
                    @endforeach
                @endforeach
            </td>
            <th colspan="5"
                align="left">
                <small>Grade Mark</small>
            </th>
            <td colspan="6" align="left">
                <?php
                $uniques1 = [];
                ?>

                    @foreach($report->shipmentdata as $shipmnet)
                        @foreach($shipmnet->shipmentcarton as $carton)
                            <?php
                            if(!in_array($carton->grademark->grademark, $uniques1)){
                                $uniques1[] = $carton->grademark->grademark;
                                echo $carton->grademark->grademark.',';
                            }
                            ?>
                        @endforeach
                    @endforeach



            </td>
        </tr>
    {{--</table>--}}
    {{--<table style="margin-top: 2%">--}}
        {{--@if(isset($report->vehicleno))--}}
            {{--<tr>--}}
                {{--<td align="left" colspan="1"> <strong>Vehicle </strong>--}}
                {{--</td>--}}
                {{--<td style="text-align: left" colspan="5">--}}
                    {{--@foreach($report->vehicleno as $vehicle)--}}
                        {{--{{$vehicle}} ,--}}
                    {{--@endforeach--}}
                {{--</td>--}}
            {{--</tr>--}}
        {{--@endif--}}
        {{--<tr>--}}
        {{--<td colspan="17" align="center"> {{$report->reportMaster->title}}</td>--}}
        {{--</tr>--}}
        <tr>
            <th style="text-align: center">
                Carton Date
            </th>
            <th style="text-align: center">
                Lot No
            </th>
            <th style="text-align: center">
                Total
            </th>
            <th style="text-align: center">
                T1
            </th>
            <th style="text-align: center">
                T2
            </th>
            <th style="text-align: center">
                T3
            </th>
            <th style="text-align: center">
                T4
            </th>
            <th style="text-align: center">
                T5
            </th>
            <th style="text-align: center">
                T6
            </th>
            <th style="text-align: center">
                T7
            </th>
            <th style="text-align: center">
                T8
            </th>
            <th style="text-align: center">
                T9
            </th>
            <th style="text-align: center">
                T10
            </th>
            <th style="text-align: center">
                T11
            </th>
            <th style="text-align: center">
                T12
            </th>
            <th style="text-align: center">
                T13
            </th>
            <th style="text-align: center">
                T14
            </th>
            <th style="text-align: center">
                T15
            </th>
            <th style="text-align: center">
                T16
            </th>
            <th style="text-align: center">
                T17
            </th>
            <th style="text-align: center">
                T18
            </th>
            <th style="text-align: center">
                T19
            </th>
            <th style="text-align: center">
                T20
            </th>
        </tr>



        @foreach($report->data  as $data)
            <tr>
                <td style="text-align: center">{{$data['carton_date']}}</td>
                <td style="text-align: center">{{ isset($data['lot_no']) ? $data['lot_no'] : 0 }}</td>
                <td style="text-align: center">{{$data['total']}}</td>
                <td style="text-align: center">{{$data['thappy1']}}</td>
                <td style="text-align: center">{{$data['thappy2']}}</td>
                <td style="text-align: center">{{$data['thappy3']}}</td>
                <td style="text-align: center">{{$data['thappy4']}}</td>
                <td style="text-align: center">{{$data['thappy5']}}</td>
                <td style="text-align: center">{{$data['thappy6']}}</td>
                <td style="text-align: center">{{$data['thappy7']}}</td>
                <td style="text-align: center">{{$data['thappy8']}}</td>
                <td style="text-align: center">{{$data['thappy9']}}</td>
                <td style="text-align: center">{{$data['thappy10']}}</td>
                <td style="text-align: center">{{$data['thappy11']}}</td>
                <td style="text-align: center">{{$data['thappy12']}}</td>
                <td style="text-align: center">{{$data['thappy13']}}</td>
                <td style="text-align: center">{{$data['thappy14']}}</td>
                <td style="text-align: center">{{$data['thappy15']}}</td>
                <td style="text-align: center">{{$data['thappy16']}}</td>
                <td style="text-align: center">{{$data['thappy17']}}</td>
                <td style="text-align: center">{{$data['thappy18']}}</td>
                <td style="text-align: center">{{$data['thappy19']}}</td>
                <td style="text-align: center">{{$data['thappy20']}}</td>
            </tr>
        @endforeach
        <tr>
            <th></th>
            <th>Total</th>
            @foreach($report->sum as $sum)
                <th style="text-align: center">{{$sum->total}}</th>
            @endforeach
            <th style="text-align: center"> {{$report->t1}} </th>
            <th style="text-align: center">{{$report->t2}}</th>
            <th style="text-align: center">{{$report->t3}}</th>
            <th style="text-align: center">{{$report->t4}}</th>
            <th style="text-align: center">{{$report->t5}}</th>
            <th style="text-align: center">{{$report->t6}}</th>
            <th style="text-align: center">{{$report->t7}}</th>
            <th style="text-align: center">{{$report->t8}}</th>
            <th style="text-align: center">{{$report->t9}}</th>
            <th style="text-align: center">{{$report->t10}}</th>
            <th style="text-align: center">{{$report->t11}}</th>
            <th style="text-align: center">{{$report->t12}}</th>
            <th style="text-align: center">{{$report->t13}}</th>
            <th style="text-align: center">{{$report->t14}}</th>
            <th style="text-align: center">{{$report->t15}}</th>
            <th style="text-align: center">{{$report->t16}}</th>
            <th style="text-align: center">{{$report->t17}}</th>
            <th style="text-align: center">{{$report->t18}}</th>
            <th style="text-align: center">{{$report->t19}}</th>
            <th style="text-align: center">{{$report->t20}}</th>
        </tr>
    </table>

@endsection

