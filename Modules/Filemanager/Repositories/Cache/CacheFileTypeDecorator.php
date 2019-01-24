<?php

namespace Modules\Filemanager\Repositories\Cache;

use Modules\Filemanager\Repositories\FileTypeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFileTypeDecorator extends BaseCacheDecorator implements FileTypeRepository
{
    public function __construct(FileTypeRepository $filetype)
    {
        parent::__construct();
        $this->entityName = 'filemanager.filetypes';
        $this->repository = $filetype;
    }
}
