<?php

return [

    'filemanager.module'=>[
        'index' => 'View Filemanager Module'
    ],

    'filemanager.filetypecategories' => [
        'index' => 'filemanager::filetypecategories.list resource',
        'create' => 'filemanager::filetypecategories.create resource',
        'edit' => 'filemanager::filetypecategories.edit resource',
        'destroy' => 'filemanager::filetypecategories.destroy resource',
    ],
    'filemanager.filetypes' => [
        'index' => 'filemanager::filetypes.list resource',
        'create' => 'filemanager::filetypes.create resource',
        'edit' => 'filemanager::filetypes.edit resource',
        'destroy' => 'filemanager::filetypes.destroy resource',
    ],
    'filemanager.filestatuses' => [
        'index' => 'filemanager::filestatuses.list resource',
        'create' => 'filemanager::filestatuses.create resource',
        'edit' => 'filemanager::filestatuses.edit resource',
        'destroy' => 'filemanager::filestatuses.destroy resource',
    ],
    'filemanager.files' => [
        'index' => 'filemanager::files.list resource',
        'create' => 'filemanager::files.create resource',
        'edit' => 'filemanager::files.edit resource',
        'destroy' => 'filemanager::files.destroy resource',
        'getFile' => 'filemanager:files.getFile.resource'
    ],
    'filemanager.fileversions' => [
        'index' => 'filemanager::fileversions.list resource',
        'create' => 'filemanager::fileversions.create resource',
        'edit' => 'filemanager::fileversions.edit resource',
        'destroy' => 'filemanager::fileversions.destroy resource',
    ],
    'filemanager.fileusers' => [
        'index' => 'filemanager::fileusers.list resource',
        'create' => 'filemanager::fileusers.create resource',
        'edit' => 'filemanager::fileusers.edit resource',
        'destroy' => 'filemanager::fileusers.destroy resource',
    ],
    'filemanager.filegroups' => [
        'index' => 'filemanager::filegroups.list resource',
        'create' => 'filemanager::filegroups.create resource',
        'edit' => 'filemanager::filegroups.edit resource',
        'destroy' => 'filemanager::filegroups.destroy resource',
    ],
// append







];
