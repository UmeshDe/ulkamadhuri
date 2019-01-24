@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('filemanager::filestatuses.title.filestatuses') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('filemanager::filestatuses.title.filestatuses') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <div id="filestatus-list" class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Status</th>
                                <th>Sequence</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($filestatuses))
                            @foreach($filestatuses as $filestatus)
                            <tr>
                                <td><input type="checkbox" class="bulk-action-chk" data-id="{{$filestatus->id}}"></td>
                                <td>{{$filestatus->status}}</td>
                                <td>{{$filestatus->sequence}}</td>
                                <td>
                                    <a href="{{ route('admin.filemanager.filestatus.edit', [$filestatus->id]) }}">
                                        {{ $filestatus->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-flat category-edit-button" data-status="{{$filestatus->status}}" data-sequence="{{$filestatus->sequence}}" data-id="{{$filestatus->id}}"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat " data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.filemanager.filestatus.destroy', [$filestatus->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>Status</th>
                                <th>Sequence</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <div id="update-div" class="box box-primary" hidden>
                <div class="box-header with-border" >
                    <h3 class="box-title">Update Filestatus</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => ['admin.filemanager.filestatus.update'], 'method' => 'post','id'=>'update-form']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback {{ $errors->has('status') ? ' has-error has-feedback' : '' }}">
                        <label for="type-status">Status</label>
                        <input type="text" class="form-control" id="status" name ="status" autofocus placeholder="Enter Status" value="{{ old('status') }}" >
                        {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('sequence') ? ' has-error has-feedback' : '' }}">
                        <label for="type-sequence">Sequence</label>
                        <input type="text" class="form-control" id="sequence"  name = "sequence" autofocus placeholder="Enter Sequence" value="{{ old('sequence') }}">
                        {!! $errors->first('sequence', '<span class="help-block">:message</span>') !!}
                    </div>
                    <input type="hidden" name="filestatus_id" id="filestatus-id">
                    <input type="hidden" name="old_status" id="old-status">
                </div>
                <!-- /.box-body -->
                <!-- /.box-body -->



                <div class="box-footer">
                    <button type="clear" class="btn btn-primary pull-left" id="btn-cancel-update">Cancel</button>
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                </div>

                {{--</div>--}}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-xs-4">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border" >
                    <h3 class="box-title">Create New Filestatus</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => ['admin.filemanager.filestatus.store'], 'method' => 'post','id'=>'create-form']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback {{ $errors->has('status') ? ' has-error has-feedback' : '' }}">
                        <label for="type-status">Status</label>
                        <input type="text" class="form-control" id="status" name ="status" autofocus placeholder="Enter Status" value="{{ old('status') }}" >
                        {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('sequence') ? ' has-error has-feedback' : '' }}">
                        <label for="type-sequence">Sequence</label>
                        <input type="text" class="form-control" id="sequence"  name = "sequence" autofocus placeholder="Enter Sequence" value="{{ old('sequence') }}">
                        {!! $errors->first('sequence', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <!-- /.box-body -->
                <!-- /.box-body -->



                <div class="box-footer">
                    <button type="clear" class="btn btn-primary pull-left" id="btn-cancel-update">Cancel</button>
                    <button type="submit" class="btn btn-primary pull-right">Create</button>
                </div>

                {{--</div>--}}
                {!! Form::close() !!}
            </div>
            <!-- /.box -->

        </div>

    </div>
    @include('core::partials.delete-modal')
@stop


@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('filemanager::filestatuses.title.create filestatus') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.filemanager.filestatus.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
            $('#select-all').on('click', function(){
                // Check/uncheck all checkboxes in the table
                var rows = categoryTable.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            $('#filetypedategory-table tbody').on('change', 'input[type="checkbox"]', function(){
                // If checkbox is not checked
                if(!this.checked){
                    var el = $('#select-all').get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if(el && el.checked && ('indeterminate' in el)){
                        // Set visual state of "Select all" control
                        // as 'indeterminate'
                        el.indeterminate = true;
                    }
                }
            });

            $(".category-edit-button").click(function () {

                $("#filestatus-list").hide();

                $("#filestatus-id").val($(this).data("id"));
                $("#old-status").val($(this).data("status"));


                $("#update-form").find('input[name="status"]').val($(this).data("status"));
                $("#update-form").find('input[name="sequence"]').val($(this).data("sequence"));

                $("#update-div").show();
            });

            $("#btn-cancel-update").click(function(event){
                event.preventDefault();
                $("#filestatus-list").show();
                $("#update-div").hide();

            });
        });
    </script>
    
    
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!!  JsValidator::formRequest('Modules\Filemanager\Http\Requests\UpdateFileStatusRequest','#update-form')->render() !!}
    {!!  JsValidator::formRequest('Modules\Filemanager\Http\Requests\CreateFileStatusRequest','#create-form')->render() !!}
    
@endpush
