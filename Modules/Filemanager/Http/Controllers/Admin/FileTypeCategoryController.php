<?php

namespace Modules\Filemanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Filemanager\Entities\FileTypeCategory;
use Modules\Filemanager\Http\Requests\CreateFileTypeCategoryRequest;
use Modules\Filemanager\Http\Requests\UpdateFileTypeCategoryRequest;
use Modules\Filemanager\Repositories\FileTypeCategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;



class FileTypeCategoryController extends AdminBaseController
{
    /**
     * @var FileTypeCategoryRepository
     */
    private $filetypecategory;

    /**
     * @var
     */
    private $auth;


    /**
     * FileTypeCategoryController constructor.
     * @param FileTypeCategoryRepository $filetypecategory
     * @param Authentication $auth
     */
    public function __construct(FileTypeCategoryRepository $filetypecategory,Authentication $auth)
    {
        parent::__construct();

        $this->filetypecategory = $filetypecategory;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $fileTypeCategories = $this->filetypecategory->allWithBuilder()->with(['owner'])->get();

        return view('filemanager::admin.filetypecategories.index', compact('fileTypeCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('filemanager::admin.filetypecategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CreateFileTypeCategoryRequest $request)
    {
        $data = [
            'name'=> $request->name,
            'folder'=> $request->folder,
            'created_by'=> $this->auth->user()->id
        ];

        $this->filetypecategory->create($data);

        return redirect()->route('admin.filemanager.filetypecategory.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('filemanager::filetypecategories.title.filetypecategories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FileTypeCategory $filetypecategory
     * @return Response
     */
    public function edit(FileTypeCategory $filetypecategory)
    {
        return view('filemanager::admin.filetypecategories.edit', compact('filetypecategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FileTypeCategory $filetypecategory
     * @param  Request $request
     * @return Response
     */
    public function update(UpdateFileTypeCategoryRequest $request)
    {
        $filetypecategory = $this->filetypecategory->find($request->category_id);

        $data = [
            'name'=> $request->name,
            'folder'=> $request->folder,
            'updated_by'=> $this->auth->user()->id
        ];

        $this->filetypecategory->update($filetypecategory, $data);

        return redirect()->route('admin.filemanager.filetypecategory.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('filemanager::filetypecategories.title.filetypecategories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FileTypeCategory $filetypecategory
     * @return Response
     */
    public function destroy(FileTypeCategory $filetypecategory)
    {

        $this->filetypecategory->destroy($filetypecategory);

        return redirect()->route('admin.filemanager.filetypecategory.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('filemanager::filetypecategories.title.filetypecategories')]));
    }

    /**
     * Deletes multiple filecategory types
     */
    public function bulkdelete(Request $request){

        try{
            $this->filetypecategory->deleteAll(json_decode($request->bulk_ids));

            return redirect()->route('admin.filemanager.filetypecategory.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('filemanager::filetypecategories.title.filetypecategories')]));

        } catch (\Exception $ex){
            return redirect()->back()
                ->withError(trans('core::errors.messages.something went wrong',['operation'=>'deleting document categories']));
        }



    }
}
