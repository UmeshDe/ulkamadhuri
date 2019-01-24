<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/filemanager'], function (Router $router) {

    /**
     * File Routes
     */
    $router->bind('file', function ($id) {
        return app('Modules\Filemanager\Repositories\FileRepository')->find($id);
    });
    $router->get('files', [
        'as' => 'admin.filemanager.file.index',
        'uses' => 'FileController@index',
        'middleware' => 'can:filemanager.files.index'
    ]);
    $router->get('files/create', [
        'as' => 'admin.filemanager.file.create',
        'uses' => 'FileController@create',
        'middleware' => 'can:filemanager.files.create'
    ]);
    $router->post('files', [
        'as' => 'admin.filemanager.file.store',
        'uses' => 'FileController@store',
        'middleware' => 'can:filemanager.files.create'
    ]);
    $router->get('files/{file}/edit', [
        'as' => 'admin.filemanager.file.edit',
        'uses' => 'FileController@edit',
        'middleware' => 'can:filemanager.files.edit'
    ]);
    $router->put('files/{file}', [
        'as' => 'admin.filemanager.file.update',
        'uses' => 'FileController@update',
        'middleware' => 'can:filemanager.files.edit'
    ]);
    $router->delete('files/{file}', [
        'as' => 'admin.filemanager.file.destroy',
        'uses' => 'FileController@destroy',
        'middleware' => 'can:filemanager.files.destroy'
    ]);

    $router->get('files/getFile/{id}', [
        'as' => 'admin.filemanager.file.getFile',
        'uses' => 'FileController@getFile',
        'middleware' =>'can:filemanager.files.getFile'
    ]);

    $router->get('files/getFileForView/{id}', [
        'as' => 'admin.filemanager.file.getFileForView',
        'uses' => 'FileController@getFileForView',
        'middleware' =>'can:filemanager.files.getFileForView'
    ]);

    $router->get('files/getAllFilesForTask/{id}', [
        'as' => 'admin.filemanager.file.getAllFilesForTask',
        'uses' => 'FileController@getAllFilesForTask',
        'middleware' =>'can:filemanager.files.getAllFilesForTask'
    ]);

    $router->post('files/fileUpload', [
        'as' => 'admin.filemanager.file.fileUpload',
        'uses' => 'FileController@fileUpload',
        'middleware' =>'can:filemanager.files.fileUpload'
    ]);

    $router->post('files/deleteFile', [
        'as' => 'admin.filemanager.file.deleteFile',
        'uses' => 'FileController@deleteFile',
        'middleware' =>'can:filemanager.files.deleteFile'
    ]);

    $router->get('files/getAllFiles/{id}', [
        'as' => 'admin.filemanager.file.getAllFiles',
        'uses' => 'FileController@getAllFiles',
        'middleware' =>'can:filemanager.files.getAllFiles'
    ]);

    $router->get('files/getAllFilesForTask/{id}', [
        'as' => 'admin.filemanager.file.getAllFilesForTask',
        'uses' => 'FileController@getAllFilesForTask',
        'middleware' =>'can:filemanager.files.getAllFilesForTask'
    ]);


    $router->get('files/uploadFile', [
        'as' => 'admin.filemanager.file.uploadFile',
        'uses' => 'FileController@uploadFile',
        'middleware' =>'can:filemanager.files.uploadFile'
    ]);

    $router->post('files/postUpload', [
        'as' => 'admin.filemanager.file.postUpload',
        'uses' => 'FileController@postUpload',
        'middleware' =>'can:filemanager.files.postUpload'
    ]);

    $router->get('files/edituploadFile/{id}', [
        'as' => 'admin.filemanager.file.edituploadFile',
        'uses' => 'FileController@edituploadFile',
        'middleware' =>'can:filemanager.files.edituploadFile'
    ]);

    $router->post('files/postEditUpload', [
        'as' => 'admin.filemanager.file.postEditUpload',
        'uses' => 'FileController@postEditUpload',
        'middleware' =>'can:filemanager.files.postEditUpload'
    ]);

    $router->get('files/viewFiles', [
        'as' => 'admin.filemanager.file.viewFiles',
        'uses' => 'FileController@viewFiles',
        'middleware' =>'can:filemanager.files.viewFiles'
    ]);

    $router->get('files/allFiles', [
        'as' => 'admin.filemanager.file.allFiles',
        'uses' => 'FileController@allFiles',
        'middleware' =>'can:filemanager.files.allFiles'
    ]);

    $router->post('files/destroySelected', [
        'as' => 'admin.filemanager.file.destroySelected',
        'uses' => 'FileController@destroySelected',
        'middleware' =>'can:filemanager.files.destroySelected'
    ]);









    /**
     * Filegroup routes
     */

    $router->bind('filegroup', function ($id) {
        return app('Modules\Filemanager\Repositories\FileGroupRepository')->find($id);
    });
    $router->get('filegroups', [
        'as' => 'admin.filemanager.filegroup.index',
        'uses' => 'FileGroupController@index',
        'middleware' => 'can:filemanager.filegroups.index'
    ]);
    $router->get('filegroups/create', [
        'as' => 'admin.filemanager.filegroup.create',
        'uses' => 'FileGroupController@create',
        'middleware' => 'can:filemanager.filegroups.create'
    ]);
    $router->post('filegroups', [
        'as' => 'admin.filemanager.filegroup.store',
        'uses' => 'FileGroupController@store',
        'middleware' => 'can:filemanager.filegroups.create'
    ]);
    $router->get('filegroups/{filegroup}/edit', [
        'as' => 'admin.filemanager.filegroup.edit',
        'uses' => 'FileGroupController@edit',
        'middleware' => 'can:filemanager.filegroups.edit'
    ]);
    $router->put('filegroups/{filegroup}', [
        'as' => 'admin.filemanager.filegroup.update',
        'uses' => 'FileGroupController@update',
        'middleware' => 'can:filemanager.filegroups.edit'
    ]);
    $router->delete('filegroups/{filegroup}', [
        'as' => 'admin.filemanager.filegroup.destroy',
        'uses' => 'FileGroupController@destroy',
        'middleware' => 'can:filemanager.filegroups.destroy'
    ]);

    /**
     * Filetype routes
     */

    $router->bind('filetype', function ($id) {
        return app('Modules\Filemanager\Repositories\FileTypeRepository')->find($id);
    });
    $router->get('filetypes', [
        'as' => 'admin.filemanager.filetype.index',
        'uses' => 'FileTypeController@index',
        'middleware' => 'can:filemanager.filetypes.index'
    ]);
    $router->get('filetypes/create', [
        'as' => 'admin.filemanager.filetype.create',
        'uses' => 'FileTypeController@create',
        'middleware' => 'can:filemanager.filetypes.create'
    ]);
    $router->post('filetypes', [
        'as' => 'admin.filemanager.filetype.store',
        'uses' => 'FileTypeController@store',
        'middleware' => 'can:filemanager.filetypes.create'
    ]);
    $router->get('filetypes/{filetype}/edit', [
        'as' => 'admin.filemanager.filetype.edit',
        'uses' => 'FileTypeController@edit',
        'middleware' => 'can:filemanager.filetypes.edit'
    ]);
    $router->put('filetypes/{filetype}', [
        'as' => 'admin.filemanager.filetype.update',
        'uses' => 'FileTypeController@update',
        'middleware' => 'can:filemanager.filetypes.edit'
    ]);
    $router->post('filetypes/{filetype}', [
        'as' => 'admin.filemanager.filetype.update',
        'uses' => 'FileTypeController@update',
        'middleware' => 'can:filemanager.filetypes.edit'
    ]);
    $router->delete('filetypes/{filetype}', [
        'as' => 'admin.filemanager.filetype.destroy',
        'uses' => 'FileTypeController@destroy',
        'middleware' => 'can:filemanager.filetypes.destroy'
    ]);

    /**
     * Filetype category routes
     */

    $router->bind('filetypecategory', function ($id) {
        return app('Modules\Filemanager\Repositories\FileTypeCategoryRepository')->find($id);
    });
    $router->get('filetypecategories', [
        'as' => 'admin.filemanager.filetypecategory.index',
        'uses' => 'FileTypeCategoryController@index',
        'middleware' => 'can:filemanager.filetypecategories.index'
    ]);
    $router->get('filetypecategories/create', [
        'as' => 'admin.filemanager.filetypecategory.create',
        'uses' => 'FileTypeCategoryController@create',
        'middleware' => 'can:filemanager.filetypecategories.create'
    ]);
    $router->post('filetypecategories', [
        'as' => 'admin.filemanager.filetypecategory.store',
        'uses' => 'FileTypeCategoryController@store',
        'middleware' => 'can:filemanager.filetypecategories.create'
    ]);
    $router->get('filetypecategories/{filetypecategory}/edit', [
        'as' => 'admin.filemanager.filetypecategory.edit',
        'uses' => 'FileTypeCategoryController@edit',
        'middleware' => 'can:filemanager.filetypecategories.edit'
    ]);
    $router->post('filetypecategories/update', [
        'as' => 'admin.filemanager.filetypecategory.update',
        'uses' => 'FileTypeCategoryController@update',
        'middleware' => 'can:filemanager.filetypecategories.edit'
    ]);
    $router->delete('filetypecategories/{filetypecategory}', [
        'as' => 'admin.filemanager.filetypecategory.destroy',
        'uses' => 'FileTypeCategoryController@destroy',
        'middleware' => 'can:filemanager.filetypecategories.destroy'
    ]);

    $router->delete('deletefiletypecategory', [
        'as' => 'admin.filemanager.filetypecategory.bulkdelete',
        'uses' => 'FileTypeCategoryController@bulkdelete',
        'middleware' => 'can:filemanager.filetypecategories.destroy'
    ]);

    /**
     * Fileuser routes
     */

    $router->bind('fileuser', function ($id) {
        return app('Modules\Filemanager\Repositories\FileUserRepository')->find($id);
    });
    $router->get('fileusers', [
        'as' => 'admin.filemanager.fileuser.index',
        'uses' => 'FileUserController@index',
        'middleware' => 'can:filemanager.fileusers.index'
    ]);
    $router->get('fileusers/create', [
        'as' => 'admin.filemanager.fileuser.create',
        'uses' => 'FileUserController@create',
        'middleware' => 'can:filemanager.fileusers.create'
    ]);
    $router->post('fileusers', [
        'as' => 'admin.filemanager.fileuser.store',
        'uses' => 'FileUserController@store',
        'middleware' => 'can:filemanager.fileusers.create'
    ]);
    $router->get('fileusers/{fileuser}/edit', [
        'as' => 'admin.filemanager.fileuser.edit',
        'uses' => 'FileUserController@edit',
        'middleware' => 'can:filemanager.fileusers.edit'
    ]);
    $router->put('fileusers/{fileuser}', [
        'as' => 'admin.filemanager.fileuser.update',
        'uses' => 'FileUserController@update',
        'middleware' => 'can:filemanager.fileusers.edit'
    ]);
    $router->delete('fileusers/{fileuser}', [
        'as' => 'admin.filemanager.fileuser.destroy',
        'uses' => 'FileUserController@destroy',
        'middleware' => 'can:filemanager.fileusers.destroy'
    ]);

    /**
     * Fileversion routes
     */
    $router->bind('fileversion', function ($id) {
        return app('Modules\Filemanager\Repositories\FileVersionRepository')->find($id);
    });
    $router->get('fileversions', [
        'as' => 'admin.filemanager.fileversion.index',
        'uses' => 'FileVersionController@index',
        'middleware' => 'can:filemanager.fileversions.index'
    ]);
    $router->get('fileversions/create', [
        'as' => 'admin.filemanager.fileversion.create',
        'uses' => 'FileVersionController@create',
        'middleware' => 'can:filemanager.fileversions.create'
    ]);
    $router->post('fileversions', [
        'as' => 'admin.filemanager.fileversion.store',
        'uses' => 'FileVersionController@store',
        'middleware' => 'can:filemanager.fileversions.create'
    ]);
    $router->get('fileversions/{fileversion}/edit', [
        'as' => 'admin.filemanager.fileversion.edit',
        'uses' => 'FileVersionController@edit',
        'middleware' => 'can:filemanager.fileversions.edit'
    ]);
    $router->put('fileversions/{fileversion}', [
        'as' => 'admin.filemanager.fileversion.update',
        'uses' => 'FileVersionController@update',
        'middleware' => 'can:filemanager.fileversions.edit'
    ]);
    $router->delete('fileversions/{fileversion}', [
        'as' => 'admin.filemanager.fileversion.destroy',
        'uses' => 'FileVersionController@destroy',
        'middleware' => 'can:filemanager.fileversions.destroy'
    ]);


    /**
     * Filestatus routes
     */

    $router->bind('filestatus', function ($id) {
        return app('Modules\Filemanager\Repositories\FileStatusRepository')->find($id);
    });
    $router->get('filestatuses', [
        'as' => 'admin.filemanager.filestatus.index',
        'uses' => 'FileStatusController@index',
        'middleware' => 'can:filemanager.filestatuses.index'
    ]);
    $router->get('filestatuses/create', [
        'as' => 'admin.filemanager.filestatus.create',
        'uses' => 'FileStatusController@create',
        'middleware' => 'can:filemanager.filestatuses.create'
    ]);
    $router->post('filestatuses', [
        'as' => 'admin.filemanager.filestatus.store',
        'uses' => 'FileStatusController@store',
        'middleware' => 'can:filemanager.filestatuses.create'
    ]);
    $router->get('filestatuses/{filestatus}/edit', [
        'as' => 'admin.filemanager.filestatus.edit',
        'uses' => 'FileStatusController@edit',
        'middleware' => 'can:filemanager.filestatuses.edit'
    ]);
    $router->put('filestatuses/{filestatus}', [
        'as' => 'admin.filemanager.filestatus.update',
        'uses' => 'FileStatusController@update',
        'middleware' => 'can:filemanager.filestatuses.edit'
    ]);
    $router->post('filestatuses/update', [
        'as' => 'admin.filemanager.filestatus.update',
        'uses' => 'FileStatusController@update',
        'middleware' => 'can:filemanager.filestatuses.edit'
    ]);
    $router->delete('filestatuses/{filestatus}', [
        'as' => 'admin.filemanager.filestatus.destroy',
        'uses' => 'FileStatusController@destroy',
        'middleware' => 'can:filemanager.filestatuses.destroy'
    ]);
// append







});
