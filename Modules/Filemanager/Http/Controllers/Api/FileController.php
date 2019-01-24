<?php

namespace Modules\Filemanager\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Filemanager\Entities\File;
use Modules\Filemanager\Helper\FileMetadata;
use Modules\Filemanager\Repositories\FileRepository;
use Modules\User\Contracts\Authentication;

class FileController extends Controller
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
        $this->file = $file;
        $this->auth = $auth;
    }

    /**
     * Delete file with id
     * @param Request $request
     * @return mixed
     */
    public function destroy(Request $request)
    {
        try {
            $file = $this->file->find($request->file_id);
            $this->file->destroy($file);
            return Response::json(['success' => true, 'message' => 'File deleted Successfully.']);
        } catch (\Exception $ex) {

            return Response::json([
                'success' => false,
                'message' => trans('core::errors.messages.something went wrong', ['operation' => 'deleting file'])
            ]);
        }
    }


    /**
     * Delete Multiple files with id
     * @param File $file
     * @param Request $request
     * @return mixed
     */
    public function destroySelected(File $file, Request $request)
    {
        try {

            $file = $this->file->deleteSelected($request->file_id);
            return Response::json(['success' => true, 'message' => 'Selected Files deleted Successfully.']);
        } catch (\Exception $ex) {

            return Response::json([
                'success' => false,
                'message' => trans('core::errors.messages.something went wrong', ['operation' => 'deleting files'])
            ]);
        }
    }

    /**
     * Delete specified file
     * @param Request $request
     * @return mixed
     */
    public function deleteFile(Request $request) {
        try {

            $file = $this->file->find($request->file_id);

            if ($file != null) {
                $file->delete();
            }

            return Response::json(['success' => true, 'message' => 'Row Successfully deleted.']);

        } catch (Exception $ex) {
            return Response::json([
                'success' => false,
                'message' =>  trans('core::errors.messages.something went wrong', ['operation' => 'deleting files'])
            ]);
        }
    }


}
