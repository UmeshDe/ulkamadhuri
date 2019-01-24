<?php

namespace Modules\Filemanager\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Filemanager\Events\Handlers\RegisterFilemanagerSidebar;

class FilemanagerServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterFilemanagerSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('filemanager', 'permissions');
        $this->publishConfig('filemanager', 'config');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileTypeCategoryRepository',
            function () {
                $repository = new \Modules\Filemanager\Repositories\Eloquent\EloquentFileTypeCategoryRepository(new \Modules\Filemanager\Entities\FileTypeCategory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Filemanager\Repositories\Cache\CacheFileTypeCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileTypeRepository',
            function () {
                $repository = new \Modules\Filemanager\Repositories\Eloquent\EloquentFileTypeRepository(new \Modules\Filemanager\Entities\FileType());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Filemanager\Repositories\Cache\CacheFileTypeDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileStatusRepository',
            function () {
                $repository = new \Modules\Filemanager\Repositories\Eloquent\EloquentFileStatusRepository(new \Modules\Filemanager\Entities\FileStatus());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Filemanager\Repositories\Cache\CacheFileStatusDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileRepository',
            function () {
                $repository = new \Modules\Filemanager\Repositories\Eloquent\EloquentFileRepository(new \Modules\Filemanager\Entities\File());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Filemanager\Repositories\Cache\CacheFileDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileVersionRepository',
            function () {
                $repository = new \Modules\Filemanager\Repositories\Eloquent\EloquentFileVersionRepository(new \Modules\Filemanager\Entities\FileVersion());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Filemanager\Repositories\Cache\CacheFileVersionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileUserRepository',
            function () {
                $repository = new \Modules\Filemanager\Repositories\Eloquent\EloquentFileUserRepository(new \Modules\Filemanager\Entities\FileUser());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Filemanager\Repositories\Cache\CacheFileUserDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Filemanager\Repositories\FileGroupRepository',
            function () {
                $repository = new \Modules\Filemanager\Repositories\Eloquent\EloquentFileGroupRepository(new \Modules\Filemanager\Entities\FileGroup());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Filemanager\Repositories\Cache\CacheFileGroupDecorator($repository);
            }
        );
// add bindings







    }
}
