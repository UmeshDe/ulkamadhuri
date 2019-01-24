<?php

namespace Modules\Filemanager\Repositories\Cache;

use Modules\Filemanager\Repositories\FileGroupRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFileGroupDecorator extends BaseCacheDecorator implements FileGroupRepository
{
    public function __construct(FileGroupRepository $filegroup)
    {
        parent::__construct();
        $this->entityName = 'filemanager.filegroups';
        $this->repository = $filegroup;
    }
}
