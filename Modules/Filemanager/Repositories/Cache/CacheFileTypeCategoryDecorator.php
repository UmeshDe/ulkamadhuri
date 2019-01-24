<?php

namespace Modules\Filemanager\Repositories\Cache;

use Modules\Filemanager\Repositories\FileTypeCategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFileTypeCategoryDecorator extends BaseCacheDecorator implements FileTypeCategoryRepository
{
    public function __construct(FileTypeCategoryRepository $filetypecategory)
    {
        parent::__construct();
        $this->entityName = 'filemanager.filetypecategories';
        $this->repository = $filetypecategory;
    }
}
