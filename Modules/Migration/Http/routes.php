<?php

Route::group(['middleware' => 'web', 'prefix' => 'migration', 'namespace' => 'Modules\Migration\Http\Controllers'], function()
{
    Route::get('/', 'MigrationController@index');
});
