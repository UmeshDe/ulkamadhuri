@extends('reports::reports.layout.master')

@section('styles')

<?php
use Dompdf\FontMetrics;
?>
@endsection

@section('content')
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
        <tr>
            <td colspan="1"
                align="left"> <strong>Container </strong>
            </td>
            <td colspan="5" align="left">
                @foreach($report->containerno as $container)
                    {{$container}} ,
                @endforeach
            </td>
        </tr>
        @endif
        <thead>
        @if(isset($report->containerno))
        <tr>
            <td colspan="6" align="center"> {{$report->reportMaster->title}}</td>
        </tr>
            @else
            <tr>
                <td colspan="16" align="left"> {{$report->reportMaster->sub_title}}</td>
            </tr>
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
            <tfoot>
            <tr>
                <td colspan="9"></td>
                <td> Total No. Of Cartons</td>
                <td style="text-align: center">{{$report->sum}}</td>
                <td colspan="5"></td>
            </tr>
            </tfoot>
    </table>
@endsection
