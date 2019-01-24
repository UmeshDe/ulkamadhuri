<?php

namespace Modules\Filemanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Filemanager\Entities\FileVersion;
use Modules\Filemanager\Repositories\FileVersionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class FileVersionController extends AdminBaseController
{
    /**
     * @var FileVersionRepository
     */
    private $fileversion;

    public function __construct(FileVersionRepository $fileversion)
    {
        parent::__construct();

        $this->fileversion = $fileversion;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$fileversions = $this->fileversion->all();

        return view('filemanager::admin.fileversions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('filemanager::admin.fileversions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->fileversion->create($request->all());

        return redirect()->route('admin.filemanager.fileversion.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('filemanager::fileversions.title.fileversions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FileVersion $fileversion
     * @return Response
     */
    public function edit(FileVersion $fileversion)
    {
        return view('filemanager::admin.fileversions.edit', compact('fileversion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FileVersion $fileversion
     * @param  Request $request
     * @return Response
     */
    public function update(FileVersion $fileversion, Request $request)
    {
        $this->fileversion->update($fileversion, $request->all());

        return redirect()->route('admin.filemanager.fileversion.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('filemanager::fileversions.title.fileversions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FileVersion $fileversion
     * @return Response
     */
    public function destroy(FileVersion $fileversion)
    {
        $this->fileversion->destroy($fileversion);

        return redirect()->route('admin.filemanager.fileversion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('filemanager::fileversions.title.fileversions')]));
    }
}
