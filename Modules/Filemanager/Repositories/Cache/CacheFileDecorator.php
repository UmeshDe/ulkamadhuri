<?php

namespace Modules\Filemanager\Repositories\Cache;

use Modules\Filemanager\Repositories\FileRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFileDecorator extends BaseCacheDecorator implements FileRepository
{
    public function __construct(FileRepository $file)
    {
        parent::__construct();
        $this->entityName = 'filemanager.files';
        $this->repository = $file;
    }
}
