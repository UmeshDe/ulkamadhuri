<?php

namespace Modules\Filemanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Filemanager\Entities\File;
use Modules\Filemanager\Helper\FileMetadata;
use Modules\Filemanager\Repositories\FileRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;
use Illuminate\Support\Facades\File as FacadesFile;

class FileController extends AdminBaseController
{
    /**
     * @var FileRepository
     */
    private $file;

    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(FileRepository $file, Authentication $auth)
    {
        parent::__construct();

        $this->file = $file;
        $this->auth = $auth;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $files = $this->file->all();

        return view('filemanager::admin.files.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('filemanager::admin.files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {    

        if ($request->file('userfile')->isValid()) {

            $fileType = app('Modules\Filemanager\Repositories\FileTypeRepository')->findWith(1, ['category', 'owner']);

            $fileMetadata = new FileMetadata();

            $fileMetadata->description = "Description";
            $fileMetadata->fileStatus = 1;
            $fileMetadata->ownerUser = $this->auth->user();
            $fileMetadata->isPublic = true;
            $fileMetadata->versionNo = 1;
            $fileMetadata->fileIdentifierFolder = '10';


            $this->file->createNewFile($request->userfile, $fileType, $fileMetadata);

            return redirect()->route('admin.filemanager.file.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('filemanager::files.title.files')]));
        } else {
            return redirect()->back()
                ->withError('Error uploading files');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  File $file
     * @return Response
     */
    public function edit(File $file)
    {
        return view('filemanager::admin.files.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  File $file
     * @param  Request $request
     * @return Response
     */
    public function update(File $file, Request $request)
    {
        $this->file->update($file, $request->all());

        return redirect()->route('admin.filemanager.file.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('filemanager::files.title.files')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  File $file
     * @return Response
     */
    public function destroy(File $file)
    {
        $this->file->destroy($file);

        return redirect()->route('admin.filemanager.file.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('filemanager::files.title.files')]));
    }


    /**
     * Download File
     * @param $fileId
     * @return mixed
     */
    public function getFile($fileId)
    {
        try {

            $file = $this->file->getFile($fileId);
            return response()->download($file->path, $file->filename);

        } catch (Exception $ex) {
            flash()->error("Error occured while downloading file please try later");
            return Redirect::back();
        }
    }

    /**
     * Preview file
     * @param $fileId
     * @return mixed
     */
    public function getFileForView($fileId)
    {
        try {

            $file = $this->file->getFile($fileId);

            $openFile = FacadesFile::get($file->path);

            $response = Response::make($openFile, 200);
            $response->header('Content-Type', $file->mimetype);
            //return Response::download($file->path, $file->filename);
            return $response;

        } catch (Exception $ex) {
            flash()->error(trans('core::errors.messages.something went wrong', ['operation' => 'downloading requested file']));
            return Redirect::back();
        }
    }

#TODO to be shifted to project module

    /**
     *  Get all files for task
     */
    public function getAllFilesForTask($taskId)
    {
        try {
            $task = app('Modules\Project\Repositories\TaskRepository')->find($taskId);
            $projectRepo = app('Modules\Project\Repositories\ProjectRepository');
            $project = $projectRepo->find($task->task_project_id);
            $fileRepo = app('Modules\Media\Repositories\FileRepository');

            $files = $fileRepo->getQuery()->whereIn('project_id', [$project->id, $project->parent_id])->get();

            $zipFile = new ZipArchive();
            $zipFileName = public_path() . "/task.zip";

            if ($zipFile->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
                throw new Exception("cannot open file");
            }

            if ($zipFile->open($zipFileName, ZIPARCHIVE::OVERWRITE) === TRUE) {
                foreach ($files as $fileModel) {

                    $file = $this->file->getFile($fileModel->id);

                    $zipFile->addFile($file->path, $file->filename);
                }

                $zipFile->close();
            }

            return Response::download(public_path() . "/task.zip", 'Tasks.zip');

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Get all files from of projectRepo
     */
    public function getAllFiles($id)
    {

        try {

            $projectRepo = app('Modules\Project\Repositories\ProjectRepository');
            $fileRepo = app('Modules\Media\Repositories\FileRepository');
            $projectIds = array();

            $project = $projectRepo->find($id);

            if ($project->parent_id != null) {

                $projects = $projectRepo->findManyByAttributes(['parent_id' => $project->parent_id]);

                foreach ($projects as $singleProject) {
                    array_push($projectIds, $singleProject->id);
                }

                array_push($projectIds, $project->parent_id);
            } else {

                array_push($projectIds, $project->id);
            }

            $files = $fileRepo->getQuery()->whereIn('project_id', $projectIds)->get();

            $zipFile = new ZipArchive();
            $zipFileName = public_path() . "/project.zip";

            //return $zipFileName;

            if ($zipFile->open($zipFileName, ZIPARCHIVE::CREATE) !== TRUE) {
                throw new Exception("cannot open file");
            }

            if ($zipFile->open($zipFileName, ZIPARCHIVE::OVERWRITE) === TRUE) {

                foreach ($files as $fileModel) {

                    $file = $this->file->getFile($fileModel->id);

                    $zipFile->addFile($file->path, $file->filename);
                }

                $zipFile->close();

            }

            return Response::download(public_path() . "/project.zip", 'Project.zip');

        } catch (Exception $ex) {
            flash()->error(trans('core::errors.messages.something went wrong', ['operation' => 'downloading requested file']));
            return Redirect::back();
        }
    }


    public function uploadFile() {
        $userId = $this->auth->user()->id;
        $category_1 = config('asgard.media.config.categories.category_1');
        $fileTypes = app('Modules\Media\Repositories\FileTypeRepository')->findManyByAttributes(['category_id' => $category_1]);
        $projects = app('Modules\Project\Repositories\ProjectRepository')->findManyByAttributes(['parent_id' => null]);
        $users = app('Modules\User\Repositories\UserRepository')->all();
        return view('project::admin.projects.partials.upload-files', compact('projects', 'fileTypes', 'file', 'userId', 'users'));
    }

    public function edituploadFile($id) {
        $file = app('Modules\Media\Repositories\FileRepository')->find($id);
        $category_1 = config('asgard.media.config.categories.category_1');
        $fileTypes = app('Modules\Media\Repositories\FileTypeRepository')->findManyByAttributes(['category_id' => $category_1]);
        $project = app('Modules\Project\Repositories\ProjectRepository')->find($file->project_id);
        //var_dump($project);
        $projects = app('Modules\Project\Repositories\ProjectRepository')->findManyByAttributes(['parent_id' => null]);
        $subprojects = app('Modules\Project\Repositories\ProjectRepository')->findManyByAttributes(['parent_id' => $project->parent_id]);
        $users = app('Modules\User\Repositories\UserRepository')->all();
        $comm_rec_and_send = config('asgard.media.config.file_types.comm_rec_and_send');
        //var_dump($file);
        return view('project::admin.projects.partials.upload-files', compact('projects', 'fileTypes', 'file', 'subprojects', 'users', 'comm_rec_and_send'));
    }

    public function postUpload(Request $request) {
        $userId = $this->auth->user()->id;
        $FileRepo = app('Modules\Media\Repositories\FileRepository');
        $newFile = [
            'project_id' => $request->project_id,
            'file_type_id' => $request->file_type_id,
            'filename' => $request->file_type_id,
            // 'extension' => $request->,
            'path' => $request->path,
            'uploaded_by' => $request->uploaded_by,
            'uploaded_date' => Carbon::parse($request->uploaded_date),
            'description' => $request->description,
            'lot_no' => $request->lot_no,
            'received_date' => Carbon::parse($request->received_date),
            'remark' => $request->remark,
            'received_path' => $request->received_path,
        ];
        $this->file->create($newFile);
        flash()->success("File uploaded successfully");
        return redirect()->route('admin.media.media.viewFiles');
    }

    public function postEditUpload(File $file, Request $request) {
        $userId = $this->auth->user()->id;

        $file->project_id = $request->project_id;
        $file->file_type_id = $request->file_type_id;
        $file->filename = $request->file_type_id;
        $file->path = $request->path;
        $file->uploaded_by = $request->uploaded_by;
        $file->uploaded_date = Carbon::parse($request->uploaded_date);
        $file->description = $request->description;
        $file->lot_no = $request->lot_no;
        $file->received_date = Carbon::parse($request->received_date);
        $file->remark = $request->remark;
        $file->received_path = $request->received_path;
        $file->save();

        flash()->success("File updated successfully");
        return redirect()->route('admin.media.media.viewFiles');
    }

    public function viewFiles() {
        $category_1 = config('asgard.media.config.categories.category_1');
        $fileTypes = app('Modules\Media\Repositories\FileTypeRepository')->findManyByAttributes(['category_id' => $category_1]);
        //$fileTypes = app('Modules\Media\Repositories\FileTypeRepository')->all();
        $fileRepo = app('Modules\Media\Repositories\FileRepository');
        $allFiles = $fileRepo->paginate(10);
        return view('project::admin.files.index', compact('allFiles', 'fileTypes'));
    }

    /**
     * Process Datatables ajax requests.
     *
     * @return Response
     */
        public function allFiles(Request $request) {

        $fileRepo = app('Modules\Media\Repositories\FileRepository');

        $typeValue = $request->typeVal;
        //To get requests for all type
        if ($typeValue == 'All') {
            $typeVal = '%';
        } else {
            $typeVal = $typeValue; //gets requests of filtered value
        }

        $allFiles = $fileRepo->getQuery()->with(['project', 'project.client', 'project.projectPlan', 'fileType', 'uploadedBy'])->where('file_type_id', 'LIKE', $typeVal)->get();

        //$allFiles = $fileRepo->allWith(['project','project.client','project.projectPlan','fileType','uploadedBy']);
        return Datatables::of($allFiles)->make(true);

    }

#end tobe shifted to project


}
