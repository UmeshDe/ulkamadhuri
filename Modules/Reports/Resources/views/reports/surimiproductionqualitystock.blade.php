@extends('reports::reports.layout.master')
<?php  ini_set('max_execution_time', -1); ?>

@section('styles')

   
@endsection

@section('content')

    <table class="export-table">
        <tr>
            <td align="left" colspan="1"> <strong>Variety </strong>
            </td>
            <td  colspan="47">
                @foreach($report->fishtypes as $type)
                    {{$type->type}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>Grade </strong>
            </td>
            <td  colspan="47">
                @if($report->grades != null)
                @foreach($report->grades as $grade)
                    {{$grade->grade}} ,
                @endforeach
                @endif
            </td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>Date </strong>
            </td>
            <td  colspan="47">
                {{$report->date}}
            </td>
        </tr>
        <thead>
        <tr>
            <td colspan="48" align="center"> {{$report->reportMaster->title}}</td>
        </tr>
        <tr>
            <td colspan="25" align="left"></td>
            <td colspan="23" align="center">
            @foreach($report->total as $total)
                {{$total->total}}
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="39" align="left"> </td>
            <td colspan="3" align="center">STANDARD</td>
            <td colspan="6"></td>
        </tr>
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
            <td colspan="32" align="center"></td>
            <td colspan="3"> Total No. Of Cartons</td>
            @foreach($report->total as $total)
                <td style="text-align: center">{{$total->total}}</td>
            @endforeach
            <td colspan="9"></td>
            @foreach($report->total as $total)
                <td style="text-align: center">{{$total->avl}}</td>
            @endforeach
            <td colspan="1">

            </td>
        </tr>
        </tfoot>
    </table>
@endsection

@section('script')

@endsection