<?php

namespace Modules\Filemanager\Repositories\Eloquent;

use Modules\Filemanager\Repositories\FileRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Http\UploadedFile;
use Modules\Filemanager\Repositories\FileTypeRepository;
use Modules\Media\Repositories\Eloquent\EloquentFileRepository as MediaFileRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Modules\Media\Helpers\FileHelper;

class EloquentFileRepository extends MediaFileRepository implements FileRepository
{
    /**
     * @param UploadedFile $file
     * @param $fileTypeId
     * @param $fileMetaData
     * @return $this|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function createNewFile(UploadedFile $file,$fileTypeId,$fileMetaData) {
        try {

            $fileMD5 = md5_file($file);
            $fileType = app(FileTypeRepository::class)->findByAttributes(['folder' => $fileTypeId]);


            $folderPath = config('asgard.media.config.files-path') . $fileType->category->folder;


            if(isset($fileMetaData->fileIdentifierFolder))
            {
                $folderPath = $folderPath . DIRECTORY_SEPARATOR .  $fileMetaData->fileIdentifierFolder;
            }

            $folderPath = $folderPath.DIRECTORY_SEPARATOR . $fileType->folder;


            $fileName = $fileMD5 . uniqid().'.' . $file->guessClientExtension();
            $filePath = $folderPath . DIRECTORY_SEPARATOR . $fileName;

            #TODO Check if file exists
            $newFile = $this->model->create([
                'filename' => $file->getClientOriginalName(),
                'path' => $filePath,
                'extension' => substr(strrchr($fileName, "."), 1),
                'mimetype' => $file->getClientMimeType(),
                'filesize' => $file->getFileInfo()->getSize(),
                'folder_id' => 0,
                'file_type_id' => $fileType->id,
                'file_md5' => $fileMD5,
                'version_no' => $fileMetaData->versionNo,
                'description' => $fileMetaData->description,
                'is_public' => $fileMetaData->isPublic,
                'file_status_id' => $fileMetaData->fileStatus,
                'uploaded_by' => $fileMetaData->ownerUser->id
            ]);


            if(isset($fileMetaData->fileUsers)){

                $fileUserRepo = app('Modules\Filemanager\Repositories\FileUserRepository');

                $fileUsers = [];

                foreach ($fileMetaData->fileUsers as $fileUser){

                    $fileUser = [
                        'file_id'=>$newFile->id,
                        'user_id'=> $fileUser->userId,
                        'can_edit' => $fileUser->canEdit,
                        'can_delete' => $fileUser->canDelete
                    ];

                    array_push($fileUsers,$fileUser);
                }
                $fileUserRepo->insert($fileUsers);
            }


            if(isset($fileMetaData->fileGroups)){
                $fileGroupRepo = app('Modules\Filemanager\Repositories\FileGroupRepository');

                $fileGroups = [];

                foreach ($fileMetaData->fileGroups as $fileGroup){
                    $fileGroup = [
                        'file_id'=>$newFile->id,
                        'group_id'=>$fileGroup->groupId,
                        'can_edit' => $fileUser->canEdit,
                        'can_delete' => $fileUser->canDelete
                    ];

                    array_push($fileGroups,$fileGroup);
                }

                $fileGroupRepo->insert($fileGroups);
            }

            //Move the uploaded file to files path
            $file->move(public_path() . $folderPath, $fileName);
            @chmod(public_path() . $filePath, 0666);

            return $newFile;

        } catch (Exception $ex) {
            throw $ex;
        }
    }



    /**
     * Returns the physical path of file id given
     * @param  int    $fileId [description]
     * @return [type]         [description]
     */
    public function getFilePath($fileId) {
        $file = $this->find($fileId);

        if ($file == null) {
            throw new Exception("Invalid file Id");
        }

        return public_path() . $file->path;
    }

    /**
     * Returns the physical path of file id given
     * @param  int    $fileId [description]
     * @return [type]         [description]
     */
    public function getFile($fileId) {
        $file = $this->find($fileId);

        if ($file == null) {
            throw new \Exception("Invalid file Id");
        }

        $file->path = public_path() . $file->path;

        $file->fileName = str_replace(strrchr($file->filename, '.'), '_' . $file->version_no . strrchr($file->filename, '.'), $file->filename);

        return $file;
    }

    /**
     * Create an UploadedFile object from absolute path
     *
     * @static
     * @param     string $path
     * @param     bool $public default false
     * @return    object(Symfony\Component\HttpFoundation\File\UploadedFile)
     * @author    Alexandre Thebaldi
     */

    public static function pathToUploadedFile($path, $public = false) {
        $name = File::filename($path);
        //var_dump($name);

        $extension = File::extension($path);

        $originalName = $name . '.' . $extension;

        $mimeType = File::mimeType($path);

        $size = File::size($path);

        $error = null;

        $test = $public;

        $object = new UploadedFile($path, $originalName, $mimeType, $size, $error, $test);

        return $object;
    }

    /**
     *Delete the selected files
     */
    public function deleteSelected($file) {
        //to include the type for notification
        $file = array();
        foreach ($file as $t) {
            array_push($file, $t);
        }
        return $this->model->whereIn('id', $file)->delete();
    }
}
