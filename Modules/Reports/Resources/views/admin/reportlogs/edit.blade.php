@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('reports::reportlogs.title.edit reportlog') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.reports.reportlog.index') }}">{{ trans('reports::reportlogs.title.reportlogs') }}</a></li>
        <li class="active">{{ trans('reports::reportlogs.title.edit reportlog') }}</li>
    </ol>
@stop

@section('content')
    {!!  Former::vertical_open()
                     ->id('reportform')
                     ->route('admin.report.generate')
                     ->method('POST') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="box box-primary">
                    <div class="body">
                        @include('reports::admin.reportlogs.partials.edit-fields')
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
                    { key: 'b', route: "<?= route('admin.reports.reportlog.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });

        $("input[name$='report_date']").click(function () {
            $("#date").show();
        })

        var start = moment().subtract(29, 'days');
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

        $('.select').select2({
            width : '100%'
        });

    </script>
@endpush
