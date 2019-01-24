<?php

namespace Modules\Filemanager\Repositories\Cache;

use Modules\Filemanager\Repositories\FileStatusRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFileStatusDecorator extends BaseCacheDecorator implements FileStatusRepository
{
    public function __construct(FileStatusRepository $filestatus)
    {
        parent::__construct();
        $this->entityName = 'filemanager.filestatuses';
        $this->repository = $filestatus;
    }
}
