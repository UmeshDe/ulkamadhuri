<?php

namespace Modules\Filemanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Filemanager\Entities\FileGroup;
use Modules\Filemanager\Repositories\FileGroupRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class FileGroupController extends AdminBaseController
{
    /**
     * @var FileGroupRepository
     */
    private $filegroup;

    public function __construct(FileGroupRepository $filegroup)
    {
        parent::__construct();

        $this->filegroup = $filegroup;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$filegroups = $this->filegroup->all();

        return view('filemanager::admin.filegroups.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('filemanager::admin.filegroups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->filegroup->create($request->all());

        return redirect()->route('admin.filemanager.filegroup.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('filemanager::filegroups.title.filegroups')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FileGroup $filegroup
     * @return Response
     */
    public function edit(FileGroup $filegroup)
    {
        return view('filemanager::admin.filegroups.edit', compact('filegroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FileGroup $filegroup
     * @param  Request $request
     * @return Response
     */
    public function update(FileGroup $filegroup, Request $request)
    {
        $this->filegroup->update($filegroup, $request->all());

        return redirect()->route('admin.filemanager.filegroup.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('filemanager::filegroups.title.filegroups')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FileGroup $filegroup
     * @return Response
     */
    public function destroy(FileGroup $filegroup)
    {
        $this->filegroup->destroy($filegroup);

        return redirect()->route('admin.filemanager.filegroup.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('filemanager::filegroups.title.filegroups')]));
    }
}
