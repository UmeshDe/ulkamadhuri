<?php

namespace Modules\Filemanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Filemanager\Entities\FileType;
use Modules\Filemanager\Http\Requests\CreateFileTypeRequest;
use Modules\Filemanager\Http\Requests\FileTypeRequest;
use Modules\Filemanager\Http\Requests\UpdateFileTypeRequest;
use Modules\Filemanager\Repositories\FileTypeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;


class FileTypeController extends AdminBaseController
{
    /**
     * @var FileTypeRepository
     */
    private $filetype;
    /**
     * @var
     */
    private $auth;

    public function __construct(FileTypeRepository $filetype,Authentication $auth)
    {
        parent::__construct();

        $this->filetype = $filetype;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filetypes = $this->filetype->all();
        $filetypecategoryrepo = app( 'Modules\Filemanager\Repositories\FileTypeCategoryRepository');

        $filetypecategoty = $filetypecategoryrepo->allWithBuilder()
            ->select(['id','name'])
            ->orderBy('name')
            ->get();


        return view('filemanager::admin.filetypes.index', compact('filetypecategoty','filetypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('filemanager::admin.filetypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CreateFileTypeRequest $request)
    {
        $data = [
            'type'=> $request->type,
            'folder'=> $request->folder,
            'category_id'=> $request->category_id,
            'created_by'=> $this->auth->user()->id
        ];
        $this->filetype->create($data);
//        $this->filetype->create($request->all());

        return redirect()->route('admin.filemanager.filetype.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('filemanager::filetypes.title.filetypes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FileType $filetype
     * @return Response
     */
    public function edit(FileType $filetype)
    {
        return view('filemanager::admin.filetypes.edit', compact('filetype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FileType $filetype
     * @param  Request $request
     * @return Response
     */
    public function update(FileType $filetype, UpdateFileTypeRequest $request)
    {
        $this->filetype->update($filetype, $request->all());

        return redirect()->route('admin.filemanager.filetype.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('filemanager::filetypes.title.filetypes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FileType $filetype
     * @return Response
     */
    public function destroy(FileType $filetype)
    {
        try{
        $this->filetype->destroy($filetype);

        return redirect()->route('admin.filemanager.filetype.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('filemanager::filetypes.title.filetypes')]));
        }
        catch (\Exception $ex){
            return redirect()->back()
                ->withError(trans('core::errors.messages.something went wrong',['operation'=>'deleting file type categories']));
        }
    }
    }
