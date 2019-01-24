@extends('reports::reports.layout.master')

@section('styles')

    <?php
    use Dompdf\FontMetrics;
    ?>
@endsection

@section('content')
    <table style="margin-top: 5%">
        <tr>
            <th colspan="25" align="center"> {{$report->reportMaster->title}}</th>
        </tr>
        <tr>
            <td colspan="25" align="left"> {{$report->reportMaster->sub_title}}</td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>Vehicle </strong>
            </td>
            <td style="text-align: left" colspan="24">
                @foreach($report->vehicleno as $vehicle)
                    {{$vehicle}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"> <strong>Container </strong>
            </td>
            <td colspan="24" align="left">
                @foreach($report->containerno as $container)
                    {{$container}} ,
                @endforeach
            </td>
        </tr>
        <thead>
        {{--<tr>--}}
            {{--<td colspan="14">Loading Date<br>--}}
                {{--From<br>--}}
                {{--Start Time<br>--}}
                {{--End Time<br>--}}
                {{--Vehicle No <br>--}}
                {{--Loading Supervisor Name--}}
            {{--</td>--}}
            {{--<td colspan="5">Unloading Date<br>--}}
                {{--To<br>--}}
                {{--Start Time<br>--}}
                {{--End Time <br>--}}
                {{--Temp<br>--}}
                {{--Unloading Supervisor Name--}}
            {{--</td>--}}
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
    </table>
@endsection
