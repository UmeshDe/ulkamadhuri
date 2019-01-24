<?php

namespace Modules\Filemanager\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterFilemanagerSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
       $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('filemanager::files.title.module heading'), function (Item $item) {
                $item->icon('fa fa-file-archive-o');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('filemanager.module.index')
                );
                $item->item(trans('filemanager::files.title.files'), function (Item $item) {
                    $item->icon('fa fa-file-text');
                    $item->weight(0);
                    $item->append('admin.filemanager.file.create');
                    $item->route('admin.filemanager.file.index');
                    $item->authorize(
                        $this->auth->hasAccess('filemanager.files.index')
                    );
                });
                $item->item(trans('filemanager::filegroups.title.filegroups'), function (Item $item) {
                    $item->icon('fa fa-files-o');
                    $item->weight(0);
                    $item->append('admin.filemanager.filegroup.create');
                    $item->route('admin.filemanager.filegroup.index');
                    $item->authorize(
                        $this->auth->hasAccess('filemanager.filegroups.index')
                    );
                });
                $item->item(trans('filemanager::filetypes.title.filetypes'), function (Item $item) {
                    $item->icon('fa fa-file-word-o');
                    $item->weight(0);
                    $item->append('admin.filemanager.filetype.create');
                    $item->route('admin.filemanager.filetype.index');
                    $item->authorize(
                        $this->auth->hasAccess('filemanager.filetypes.index')
                    );
                });
                $item->item(trans('filemanager::filetypecategories.title.filetypecategories'), function (Item $item) {
                    $item->icon('fa fa-filter');
                    $item->weight(0);
                    $item->append('admin.filemanager.filetypecategory.create');
                    $item->route('admin.filemanager.filetypecategory.index');
                    $item->authorize(
                        $this->auth->hasAccess('filemanager.filetypecategories.index')
                    );
                });
                $item->item(trans('filemanager::fileusers.title.fileusers'), function (Item $item) {
                    $item->icon('fa fa-users');
                    $item->weight(0);
                    $item->append('admin.filemanager.fileuser.create');
                    $item->route('admin.filemanager.fileuser.index');
                    $item->authorize(
                        $this->auth->hasAccess('filemanager.fileusers.index')
                    );
                });
                $item->item(trans('filemanager::fileversions.title.fileversions'), function (Item $item) {
                    $item->icon('fa fa-archive');
                    $item->weight(0);
                    $item->append('admin.filemanager.fileversion.create');
                    $item->route('admin.filemanager.fileversion.index');
                    $item->authorize(
                        $this->auth->hasAccess('filemanager.fileversions.index')
                    );
                });
                $item->item(trans('filemanager::filestatuses.title.filestatuses'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.filemanager.filestatus.create');
                    $item->route('admin.filemanager.filestatus.index');
                    $item->authorize(
                        $this->auth->hasAccess('filemanager.filestatuses.index')
                    );
                });
// append







            });
        });

        return $menu;
    }
}
