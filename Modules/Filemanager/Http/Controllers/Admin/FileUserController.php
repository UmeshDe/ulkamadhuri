<?php

namespace Modules\Filemanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Filemanager\Entities\FileUser;
use Modules\Filemanager\Repositories\FileUserRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class FileUserController extends AdminBaseController
{
    /**
     * @var FileUserRepository
     */
    private $fileuser;

    public function __construct(FileUserRepository $fileuser)
    {
        parent::__construct();

        $this->fileuser = $fileuser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$fileusers = $this->fileuser->all();

        return view('filemanager::admin.fileusers.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('filemanager::admin.fileusers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->fileuser->create($request->all());

        return redirect()->route('admin.filemanager.fileuser.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('filemanager::fileusers.title.fileusers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FileUser $fileuser
     * @return Response
     */
    public function edit(FileUser $fileuser)
    {
        return view('filemanager::admin.fileusers.edit', compact('fileuser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FileUser $fileuser
     * @param  Request $request
     * @return Response
     */
    public function update(FileUser $fileuser, Request $request)
    {
        $this->fileuser->update($fileuser, $request->all());

        return redirect()->route('admin.filemanager.fileuser.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('filemanager::fileusers.title.fileusers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FileUser $fileuser
     * @return Response
     */
    public function destroy(FileUser $fileuser)
    {
        $this->fileuser->destroy($fileuser);

        return redirect()->route('admin.filemanager.fileuser.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('filemanager::fileusers.title.fileusers')]));
    }
}
