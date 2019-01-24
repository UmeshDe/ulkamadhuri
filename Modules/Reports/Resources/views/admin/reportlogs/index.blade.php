@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('reports::reportlogs.title.reportlogs') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('reports::reportlogs.title.reportlogs') }}</li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    Generated Reports
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Serial No</th>
                                <th>Report Name</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($reportMasters)): ?>
                            <?php $counter = 1 ?>
                            <?php foreach ($reportMasters as $reportlog): ?>
                            <tr>
                                @if($reportlog->id !== 14)
                                <td>Report{{$counter}}</td>
                                <td>{{$reportlog->name}}</td>
                                <td>
                                    <a href="{{ route('admin.reports.reportlog.edit', [$reportlog->id]) }}">
                                        {{ $reportlog->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        {{--<button class="btn btn-info btn-flat" data-toggle="modal" data-target="#filters-modal" data-action-target="{{ route('admin.reports.reportlog.filter', [$reportlog->id]) }}"></button>--}}
                                        {{--<button class="btn btn-info btn-flat filters" data-id="{{$reportlog->id}}" data-toggle="modal" data-target="#filters-modal" ><span style="color:white"></span></button>--}}
                                        <a href="{{ route('admin.reports.reportmaster.edit', [$reportlog->id]) }}"
                                           class="btn btn-default btn-flat"><i class="fa fa-pencil"></i>Select Filters</a>
                                        {{--<button class="btn btn-danger btn-flat" data-toggle="modal"--}}
                                                {{--data-target="#modal-delete-confirmation"--}}
                                                {{--data-action-target="{{ route('admin.reports.reportlog.destroy', [$reportlog->id]) }}">--}}
                                            {{--<i class="fa fa-trash"></i></button>--}}
                                    </div>
                                </td>
                                @endif
                            </tr>
                            <?php $counter++ ?>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            {{--<tr>--}}
                                {{--<th>{{ trans('core::core.table.created at') }}</th>--}}
                                {{--<th>{{ trans('core::core.table.actions') }}</th>--}}
                            {{--</tr>--}}
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('reports::modal.filters-modal')
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('reports::reportlogs.title.create reportlog') }}</dd>
    </dl>
@stop

@push('js-stack')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).keypressAction({
            actions: [
                {key: 'c', route: "<?= route('admin.reports.reportlog.create') ?>"}
            ]
        });

        $("input[name$='report_date']").click(function () {
            $("#date").show();
        });
        $('#po').select2({
            width: '50%'
        });
        $('#vehicle-no').select2({
            width: '50%'
        });
        $('#container-no').select2({
            width: '50%'
        });
    });
</script>
<?php $locale = locale(); ?>
<script type="text/javascript">
    $(function () {
        $('.data-table').dataTable({
            "paginate": false,
            "lengthChange": true,
            "filter": true,
            "sort": true,
            "info": true,
            "autoWidth": true,
            "order": [[0, "desc"]],
            "language": {
                "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
            }
        });
    });


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


</script>
@endpush
