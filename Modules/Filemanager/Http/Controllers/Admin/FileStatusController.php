<?php

namespace Modules\Filemanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Filemanager\Entities\FileStatus;
use Modules\Filemanager\Http\Requests\CreateFileStatusRequest;
use Modules\Filemanager\Http\Requests\FilestatusRequest;
use Modules\Filemanager\Http\Requests\UpdateFileStatusRequest;
use Modules\Filemanager\Http\Requests\UpdateFileTypeCategoryRequest;
use Modules\Filemanager\Repositories\FileStatusRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class FileStatusController extends AdminBaseController
{
    /**
     * @var FileStatusRepository
     */
    private $filestatus;
    /**
     * @var
     */
    private $auth;


    public function __construct(FileStatusRepository $filestatus)
    {
        parent::__construct();

        $this->filestatus = $filestatus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filestatuses = $this->filestatus->all();

        return view('filemanager::admin.filestatuses.index', compact('filestatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('filemanager::admin.filestatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CreateFileStatusRequest $request)
    {
        $data = [
            'status' => $request->status,
            'sequence' => $request->sequence,
        ];
        $this->filestatus->create($data);

        return redirect()->route('admin.filemanager.filestatus.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('filemanager::filestatuses.title.filestatuses')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FileStatus $filestatus
     * @return Response
     */
    public function edit(FileStatus $filestatus)
    {
        return view('filemanager::admin.filestatuses.edit', compact('filestatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FileStatus $filestatus
     * @param  Request $request
     * @return Response
     */
    public function update(FileStatus $filestatus, UpdateFileStatusRequest $request)
    {
        $filestatus = $this->filestatus->find($request->filestatus_id);
        $data = [
            'status' => $request->status,
            'sequence' => $request->sequence,
        ];
        $this->filestatus->update($filestatus,$data);

        return redirect()->route('admin.filemanager.filestatus.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('filemanager::filestatuses.title.filestatuses')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FileStatus $filestatus
     * @return Response
     */
    public function destroy(FileStatus $filestatus)
    {
        $this->filestatus->destroy($filestatus);

        return redirect()->route('admin.filemanager.filestatus.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('filemanager::filestatuses.title.filestatuses')]));
    }
}
