@extends('layouts.master')

@section('content-header')
    {{--<h1>--}}
        {{--{{ trans('reports::reportmasters.title.edit reportmaster') }}--}}
    {{--</h1>--}}
    {{--<ol class="breadcrumb">--}}
        {{--<li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>--}}
        {{--<li><a href="{{ route('admin.reports.reportmaster.index') }}">{{ trans('reports::reportmasters.title.reportmasters') }}</a></li>--}}
        {{--<li class="active">{{ trans('reports::reportmasters.title.edit reportmaster') }}</li>--}}
    {{--</ol>--}}
@stop
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">

@section('content')
    {!!  Former::vertical_open()
                   ->id('reportform')
                   ->route('admin.report.generate')
                   ->target('_blank')
                   ->method('POST') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="box box-primary">
                    <div class="body">
                        @include('reports::admin.reportmasters.partials.edit-fields')
                    </div>
                    <div class="box-footer">
                        {!! Former::actions()
                        ->large_primary_submit('Generate')
                        ->large_inverse_reset('Reset')
                        ->addClass('col-lg-offset-4 col-sm-offset-4 col-lg-10 col-sm-8')
                        ->raw()
                        !!}
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>

    {!! Former::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    {key: 'b', route: "<?= route('admin.reports.reportmaster.index') ?>"}
                ]
            });
            {{--if ({{$reportmaster->id == 29 || $reportmaster->id == 28}})--}}
            {{--{--}}
                {{--document.getElementById("report_date3").enabled = true;--}}
            {{--}--}}
            $('#report_date').select2({
                width: '100%'
            });
            $('#invoice_id,#container_id').select2({
                width : '100%'
            })
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
        $("#report_date").change(function () {
            if($(this).val() != "")
            {
                $("#date").show();
            }
            else
            {
                $("#date").hide();
            }
        })

        var start = moment().subtract(15, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
        }
        $('#reportrange').daterangepicker({

            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);

        // $('#report_Type,#buyer,#vehicle-no,#container-no,#grade,#variety,#ic,#po,#fm_id,#d_id,#s_id,#a_id,#c_id,#p_id,#b_id,#m_id,#w_id,#q_id,#sc_id,#lc_id,#bagcolor_id').select2({
        //     width : '100%'
        // });

    </script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#grade').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Grade',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'grade[]';
                }
            });
            $('#vehicle-no').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Vehicle No',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'vehicle[]';
                }
            });
            $('#container-no').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Container No',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'container[]';
                }
            });
            $('#eia_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select EIA Number',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'eia[]';
                }
            });
            $('#cm_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select CM',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'cm[]';
                }
            });
            $('#place').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Place',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'place[]';
                }
            });
            $('#ic').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select IC',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'ic[]';
                }
            });

            $('#bagcolor_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Bag Color',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'bagcolor[]';
                }
            });
            $('#buyer').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Buyer',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'buyer[]';
                }
            });
            $('#fm_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code FM',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'fm[]';
                }
            });
            $('#d_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code D',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'd[]';
                }
            });
            $('#fr_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code D',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'fr[]';
                }
            });
            $('#s_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code S',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 's[]';
                }
            });
            $('#a_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code A',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'a[]';
                }
            });
            $('#c_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code C',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'c[]';
                }
            });
            $('#p_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code P',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'p[]';
                }
            });
            $('#b_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code B',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'b[]';
                }
            });
            $('#m_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code M',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'm[]';
                }
            });
            $('#w_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code W',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'w[]';
                }
            });
            $('#q_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code P',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'q[]';
                }
            });
            $('#sc_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code P',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'sc[]';
                }
            });
            $('#lc_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code P',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'lc[]';
                }
            });
            $('#i_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code I',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'i[]';
                }
            });
            $('#k_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code K',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'k[]';
                }
            });
            $('#e_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code E',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'e[]';
                }
            });
            $('#t_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code T',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 't[]';
                }
            });
            $('#sg_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code SG',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'sg[]';
                }
            });
            $('#kg_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code KG',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'kg[]';
                }
            });
            $('#g_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code G',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'g[]';
                }
            });
            $('#h_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code H',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'h[]';
                }
            });
            $('#rc_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code RC',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'rc[]';
                }
            });
            $('#mk_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code MK',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'mk[]';
                }
            });
            $('#v_id').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Code MK',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'v[]';
                }
            });
            $('#variety').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Variety',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'variety[]';
                }
            });
            $('#po').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select PO',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'po[]';
                }
            });
            $('#shipmentpo').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                disableIfEmpty: true,
                inheritClass: true,
                buttonClass: 'btn btn-default',
                buttonWidth: '320px',
                nonSelectedText: 'Select Shipment PO',
                buttonContainer: '<div class="btn-group" id="example-selectedClass-container"></div>',
                selectedClass: 'multiselect-selected',
                checkboxName: function(option) {
                    return 'shipmentpo[]';
                }
            });
        });

        // $("select option").prop("selected", "selected");

        $('.select option').prop("selected" , "selected");

        $('#invoice_id').select2().on('change' , function () {

            var invoiceno = $(this).val();

            $.ajax({
                type: 'GET',
                url: '{{URL::route('admin.process.shipment.getContainer')}}',
                data: {
                    id : invoiceno,
                    _token: $('meta[name="token"]').attr('value'),
                },
                success : function (response) {
                    $('#container_id').html('<option/>');
                    $.each(response.containers, function (i , item) {
                        $('#container_id').append('<option  data-id ='+item.id+'  >'+ item.container_no + '</option>');
                    });
                },
                error: function (xhr, ajaxOption, thrownError) {
                }
            });
        });
    </script>
@endpush
