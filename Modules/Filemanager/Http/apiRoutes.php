<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['middleware' => 'api.token'], function (Router $router) {

    /**
     * Files routes
     */

    $router->get('files/destroy', [
        'as' => 'api.filemanager.file.destroy',
        'uses' => 'FileController@destroy',
        'middleware' => 'token-can:filemanager.files.destroy'
    ]);

    $router->post('files/destroySelected', [
      'as' => 'api.filemanager.file.destroySelected',
      'uses' => 'FileController@destroySelected',
      'middleware' =>'token-can:filemanager.files.destroySelected'
    ]);

    $router->post('files/deleteFile', [
        'as' => 'api.filemanager.file.deleteFile',
        'uses' => 'FileController@deleteFile',
        'middleware' =>'can:media.media.deleteFile'
    ]);

});
