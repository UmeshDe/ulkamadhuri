<?php

namespace Modules\Filemanager\Repositories\Cache;

use Modules\Filemanager\Repositories\FileUserRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFileUserDecorator extends BaseCacheDecorator implements FileUserRepository
{
    public function __construct(FileUserRepository $fileuser)
    {
        parent::__construct();
        $this->entityName = 'filemanager.fileusers';
        $this->repository = $fileuser;
    }
}
