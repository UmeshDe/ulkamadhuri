@extends('reports::reports.layout.master')
<?php  ini_set('max_execution_time', -1); ?>

@section('styles')

    <?php
    use Dompdf\FontMetrics;
    ?>
@endsection

@section('content')


    <table class="export-table">
        <tr>
            <th colspan="38" align="left"> {{$report->date}}</th>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>Variety </strong>
            </td>
            <td style="text-align: left" colspan="37">
                @foreach($report->types as $type)
                    {{$type->type}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>EIA No </strong>
            </td>
            <td style="text-align: left" colspan="37">
                @foreach($report->approval as $approval)
                    {{$approval->app_number}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td align="left" colspan="1"> <strong>CM </strong>
            </td>
            <td style="text-align: left" colspan="37">
                @foreach($report->checkmark as $checkmark)
                    {{$checkmark->cm}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> Bag Color </strong>
            </td>
            <td colspan="37"
                align="left">
                @foreach($report->color as $color)
                    {{$color->color}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"> <strong>PO No. </strong>
            </td>
            <td colspan="37"
                align="left">
                @if(count($report->pos) > 1)
                    @foreach($report->pos as $po)
                        {{$po['po_no']  }} ,
                    @endforeach
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> FM Code </strong>
            </td>
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
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
            <td colspan="37"
                align="left">
                @foreach($report->lccode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> KT Code </strong>
            </td>
            <td colspan="37"
                align="left">
                @foreach($report->frcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="1"
                align="left"><strong> V Code </strong>
            </td>
            <td colspan="37"
                align="left">
                @foreach($report->vcode as $code)
                    {{$code->code}} ,
                @endforeach
            </td>
        </tr>
        {{--<tr>--}}
            {{--<td colspan="1"--}}
                {{--align="left"><strong> BuyerCode </strong>--}}
            {{--</td>--}}
            {{--<td colspan="37"--}}
                {{--align="left">--}}
                {{--@foreach($report->buyercode as $buyer)--}}
                    {{--{{$buyer->buyer_code}} ,--}}
                {{--@endforeach--}}
            {{--</td>--}}
        {{--</tr>--}}
        <thead>
        <tr>
            <td colspan="38" align="center"> {{$report->reportMaster->title}}</td>
        </tr>
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
        </tbody>
        <tfoot>
        <tr>
            <td colspan="32" align="center"></td>
            <td colspan="3"> Total No. Of Cartons</td>
            <td style="text-align: center">{{$report->reportMaster->subfooter}}</td>
            <td colspan="2"></td>
        </tr>
        </tfoot>
    </table>
@endsection
