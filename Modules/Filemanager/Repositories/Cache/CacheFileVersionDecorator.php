<?php

namespace Modules\Filemanager\Repositories\Cache;

use Modules\Filemanager\Repositories\FileVersionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFileVersionDecorator extends BaseCacheDecorator implements FileVersionRepository
{
    public function __construct(FileVersionRepository $fileversion)
    {
        parent::__construct();
        $this->entityName = 'filemanager.fileversions';
        $this->repository = $fileversion;
    }
}
