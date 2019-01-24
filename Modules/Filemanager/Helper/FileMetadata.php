<?php

namespace Modules\Filemanager\Helper;

class FileMetadata
{

    public $description;
    public $versionNo;
    public $isPublic;
    public $fileStatus;
    public $ownerUser;

    public $fileUsers;
    public $fileGroups;
    public $fileIdentifierFolder;


    public function __construct()
    {
        $this->versionNo = 1;
        $this->isPublic = false;
        $this->fileStatus = 0;
        $this->fileIdentifierFolder = "";
        $this->description="";

    }
}