@extends('reports::reports.layout.master')
<?php  ini_set('max_execution_time', -1); ?>

@section('styles')

    <?php
    use Dompdf\FontMetrics;
    ?>
@endsection

@section('content')
    <table>
        <tr>
            <th style="margin-inside: 20px" colspan="10" align="center"><small>{{$report->reportMaster->title}}</small> </th>
        </tr>
        <tr>
            <th colspan="2"
                align="left"> <small>Container </small>
            </th>
            <td colspan="2" align="left">
                {{$report->containerno}}
            </td>
            <th colspan="2"
                align="left"> <small>Shipment Date  </small>
            </th>
            <td colspan="4" align="left">
                {{\Carbon\Carbon::parse($report->shipment->date)->format(PHP_DATE_FORMAT)}}
            </td>
        </tr>
        <tr>
            <th colspan="2"
                align="left"> <small>PO No. </small>
            </th>
            <td colspan="2" align="left">
                {{$report->shipment->invoice_no}}
            </td>
            <th colspan="2"
                align="left"> <small>Approval No.</small>
            </th>
            <td colspan="4" align="left">
                {{isset($report->shipment->approvalno) ? $report->shipment->approvalno->app_number : ''}}
            </td>
        </tr>
        <tr>
            <th colspan="2"
                align="left"> <small>Total Cartons</small>
            </th>
            <td colspan="2" align="left">
            @foreach($report->sum as $sum)
                    {{$sum->total}}
             @endforeach
            </td>
            <th colspan="2"
                align="left"> <small>Supervisor</small>
            </th>
            <td colspan="4" align="left">
                {{$report->shipment->supervisor->first_name}}
            </td>
        </tr>
        <tr>
            <th colspan="2"
                align="left"> <small>Vehicle No.</small>
            </th>
            <td colspan="2" align="left">
                {{$report->shipment->vehicle_no}}
            </td>
            <th colspan="2"
                align="left"> <small>Container Seal No.</small>
            </th>
            <td colspan="4" align="left">
                {{$report->shipment->seal_no}}
            </td>
        </tr>
        <tr>
            <th colspan="2"
                align="left"> <small>Temperature</small>
            </th>
            <td colspan="2" align="left">
                {{$report->shipment->temperature}}
            </td>
            <td colspan="2"
                align="left">
            </td>
            <td colspan="4" align="left">

            </td>
        </tr>
    </table>
    <table style="margin-top: 5%">
        @if(isset($report->vehicleno))
            <tr>
                <td align="left" colspan="1"> <strong>Vehicle </strong>
                </td>
                <td style="text-align: left" colspan="5">
                    @foreach($report->vehicleno as $vehicle)
                        {{$vehicle}} ,
                    @endforeach
                </td>
            </tr>
        @endif
        @if(isset($report->containerno))

        @endif
        <thead>
        @if(isset($report->containerno))


        @endif
        {{--<tr>--}}
        {{--<td colspan="17" align="center"> {{$report->reportMaster->title}}</td>--}}
        {{--</tr>--}}
        <tr>
            @foreach($report->columns as $column)
                <th style="text-align: center">
                    {{isset($column['display_name'])?$column['display_name']:''}}
                </th>
            @endforeach
        </tr>
        </thead>
        <?php
        $i = 0;
        ?>
        @foreach($report->data as $row)
            <?php $i++;
            ?>
            <tr>
                @foreach($report->columns as $column)
                    <td style="text-align: center">

                        <?php $value;

                        //Set if value to the given value if the force value is set
                        if(isset($column['force_value'])){
                            $value = $column['force_value'];
                        }
                        else if(isset($column['type'])){
                            //Column type is set and it is a rowid column
                            if($column['type'] === REPORT_ROWNO_COLUMN){
                                $value = $i;
                            }
                            //Column type is set and it is a relation column
                            else if($column['type'] === REPORT_RELATION_COLUMN){

                                //Get the final relation model
                                $modelArray  = explode('.',$column['column_name']);
                                $relationModel = $row;

                                foreach ($modelArray as $subModel){
                                    $relationModel = $relationModel->{$subModel};
                                }

                                //Custom function is set so call custom function
                                if(isset($column['function'])){
                                    $value = $column['function']($relationModel,$column['relation_column']);
                                }
                                else{
                                    $value = isset($relationModel)?$relationModel->{$column['relation_column']}:'';
                                }
                            }
                        }
                        else{
                            $value = $row->{$column['column_name']};
                        }

                        //Format the value of the model
                        if(isset($column['format'])){
                            $value = formatValue($value,$column['format']);
                        }

                        if(!isset($value)){
                            if(isset($column['default_value'])){
                                $value = $column['default_value'];
                            }
                            else{
                                $value = "-";
                            }
                        }
                        ?>


                        {{$value}}

                    </td>
                @endforeach
            </tr>
        @endforeach
        <tr>
            <td colspan="8"></td>
            <td>Total</td>
            @foreach($report->sum as $sum)
               <td style="text-align: center">{{$sum->total}}</td>
            @endforeach
        </tr>
    </table>
@endsection
