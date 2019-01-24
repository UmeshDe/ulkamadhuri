@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('filemanager::filetypecategories.title.filetypecategories') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('filemanager::filetypecategories.title.filetypecategories') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- Horizontal Form -->
            <div id="category-list" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Document Type Categories</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-flat">Bulk Action</button>
                        <button type="button" class="btn btn-flat dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a data-message="Are you sure you want to delete :count categories selected" data-toggle="modal" data-select-item-message="Please select category to delete" data-bulkaction="true"  data-action-method = "post" data-chkbox-class="bulk-action-chk" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.filemanager.filetypecategory.bulkdelete') }}"><i class="fa fa-trash"></i>Delete</a>
                            </li>
                        </ul>
                    </div>
                    <table id="filetypedategory-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>
                                <input name="chk_select_all" value="1" id="select-all" type="checkbox" />
                            </th>
                            <th>Name</th>
                            <th>Folder</th>
                            <th>Created By</th>
                            <th>Created On</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fileTypeCategories as $fileTypeCategory)
                            <tr>
                                <td><input type="checkbox" class="bulk-action-chk" data-id="{{$fileTypeCategory->id}}"></td>
                                <td>{{ $fileTypeCategory->name }}</td>
                                <td>{{ $fileTypeCategory->folder }}</td>
                                <td>{{ isset($fileTypeCategory->owner)?$fileTypeCategory->owner->first_name:"NA"}}
                                </td>
                                <td>{{$fileTypeCategory->created_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-flat category-edit-button"  data-name="{{ $fileTypeCategory->name }}" data-id="{{$fileTypeCategory->id}}" data-folder="{{$fileTypeCategory->folder}}"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.filemanager.filetypecategory.destroy', [$fileTypeCategory->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Folder</th>
                            <th>Created By</th>
                            <th>Created On</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->

            <div id ="update-div" class="box box-primary" hidden>
                <div class="box-header with-border">
                    <h3 class="box-title">Change Document Type Categories</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => ['admin.filemanager.filetypecategory.update'], 'method' => 'post','id'=>'update-form']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Category Name</label>
                        <input type="text" class="form-control" id="type-name"  name = "name" autofocus placeholder="Enter File Type" value="{{ old('name') }}">
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('folder') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleInputEmail1">Folder Name</label>
                        <input type="text" class="form-control" name="folder" id="folder" placeholder="Enter folder name">
                        {!! $errors->first('folder', '<span class="help-block">:message</span>') !!}
                    </div>
                    <input type="hidden" id="category-id" name="category_id">
                    <input type="hidden" id="old-name" name="old_name">

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button class="btn btn-primary pull-left" id="btn-cancel-update">Cancel</button>
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>

        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">New Document Type Categories</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                {!! Form::open(['route' => ['admin.filemanager.filetypecategory.store'], 'method' => 'post','id'=>'create-form']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Category Name</label>
                        <input type="text" class="form-control" id="type-name"  name = "name" autofocus placeholder="Enter File Type" value="{{ old('name') }}">
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('folder') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleInputEmail1">Folder Name</label>
                        <input type="text" class="form-control" name="folder" id="folder" placeholder="Enter folder name">
                        {!! $errors->first('folder', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Create</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    @include('core::partials.delete-modal')
@stop


@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('filemanager::filetypecategories.title.create filetypecategory') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.filemanager.filetypecategory.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            var categoryTable =  $('#filetypedategory-table').DataTable({
                "columnDefs": [{
                    'targets': 0,
                    'searchable':false,
                    'orderable':false,
                    'className': 'dt-body-center',
                }],
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
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

                $("#category-list").hide();

                $("#category-id").val($(this).data("id"));
                $("#old-name").val($(this).data("name"));


                $("#update-form").find('input[name="name"]').val($(this).data("name"));
                $("#update-form").find('input[name="folder"]').val($(this).data("folder"));

                $("#update-div").show();
            });

            $("#btn-cancel-update").click(function(event){
                event.preventDefault();
                $("#category-list").show();
                $("#update-div").hide();

            });


        });
    </script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!!  JsValidator::formRequest('Modules\Filemanager\Http\Requests\UpdateFileTypeCategoryRequest','#update-form')->render() !!}
    {!!  JsValidator::formRequest('Modules\Filemanager\Http\Requests\CreateFileTypeCategoryRequest','#create-form')->render() !!}

@endpush

