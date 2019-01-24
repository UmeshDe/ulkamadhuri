@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('filemanager::filetypes.title.filetypes') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('filemanager::filetypes.title.filetypes') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">

                <div class="box box-primary" id="category-list">
                    <div class="box-header">
                    </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="filetype-table" class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>
                                    <input name="chk_select_all" value="1" id="select-all" type="checkbox" />
                                </th>
                                <th>Name</th>
                                <th>Folder</th>
                                <th>{{ trans('created by') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($filetypes))
                            @foreach ($filetypes as $filetype)
                            <tr>
                                <td><input type="checkbox" class="bulk-action-chk" data-id="{{$filetype->id}}"></td>
                                <td>
                                    {{$filetype->type}}
                                </td>
                                <td>
                                    {{$filetype->folder}}
                                </td>
                                <td>
                                    <a href="{{ route('admin.filemanager.filetype.edit', [$filetype->id]) }}">
                                        {{ $filetype->created_by }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.filemanager.filetype.edit', [$filetype->id]) }}">
                                        {{ $filetype->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        {{--href="{{ route('admin.filemanager.filetype.edit', [$filetype->id]) }}"--}}
                                        <a  class="btn btn-default btn-flat category-edit-button" data-type="{{ $filetype->type }}" data-folder="{{$filetype->folder}}" data-id="{{$filetype->id}}"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.filemanager.filetype.destroy', [$filetype->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                           </tr>
                            @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Folder</th>
                                <th>create_by</th>
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
            <div id ="update-div" class="box box-primary" hidden>
                <div class="box-header with-border">
                    <h3 class="box-title">Change File Type Name</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => ['admin.filemanager.filetype.update',":id"], 'method' => 'post','id'=>'update-form']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Category Name</label>
                        <input type="text" class="form-control" id="type-name"  name = "type" autofocus placeholder="Enter File Type" value="{{ old('type') }}">
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Folder Name</label>
                        <input type="text" class="form-control" id="folder-name"  name = "folder" autofocus placeholder="Enter Folder Name" value="{{ old('folder') }}">
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button class="btn btn-primary pull-left" id="btn-cancel-update">Cancel</button>
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
            <!-- /.box -->

        <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-primary" >
                <div class="box-header with-border" >
                    <h3 class="box-title">New File Type Categories</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => ['admin.filemanager.filetype.store'], 'method' => 'post','id'=>'create-form']) !!}
                <div class="box-body">
                    <div clamasterss="form-group has-feedback {{ $errors->has('type') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Type</label>
                        <input type="text" class="form-control" id="type-name"  name = "type" autofocus placeholder="Enter Type" value="{{ old('name') }}" >
                        {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('folder') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Folder</label>
                        <input type="text" class="form-control" id="folder-name"  name = "folder" autofocus placeholder="Enter Folder Name" value="{{ old('name') }}">
                        {!! $errors->first('folder', '<span class="help-block">:message</span>') !!}
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('category_id') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Category Name</label>
                        {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
                        <select class="itemName dropdown" id="itemName" name="category_id">
                            <option></option>
                            @foreach($filetypecategoty as $fileCategory)
                                <option value="{{$fileCategory->id}}">
                                    {{$fileCategory->name}}
                                </option>
                            @endforeach
                        </select>
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
        <dd>{{ trans('filemanager::filetypes.title.create filetype') }}</dd>
    </dl>
@stop

@push('js-stack')
   <script type="text/javascript">

        $("#itemName").select2({
            placeholder: 'Select an item',
            width:'100%',
        });
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.filemanager.filetype.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            var categoryTable =  $('#filetype-table').DataTable({
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
            var rows = categoryTable.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

            $('#filetype tbody').on('change', 'input[type="checkbox"]', function(){
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
            var action =  $('#update-form').attr('action').replace(":id",$(this).data("id"))
                $("#category-list").hide();
                $("#update-form").attr('action',action);
                $("#update-form").find('input[name="type"]').val($(this).data("type"))
                $("#update-div").show();
        });

            $("#btn-cancel-update").click(function(event){
                event.preventDefault();
                $("#category-list").show();
                $("#update-div").hide();

        });

            $("#btn-update").click(function(event){
                event.preventDefault();
                $("#category-list").show();
                $("#update-div").hide();

            });
        });
    </script>
	
	{{--laravel  validation--}}
	<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
	{!!  JsValidator::formRequest('Modules\Filemanager\Http\Requests\UpdateFileTypeRequest','#update-form')->render() !!}
	{!!  JsValidator::formRequest('Modules\Filemanager\Http\Requests\CreateFileTypeRequest','#create-form')->render() !!}


@endpush
