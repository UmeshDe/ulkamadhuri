<?php

use Illuminate\Routing\Router;

/** @var Router $router */
if (! App::runningInConsole()) {
    $router->get('/', [
        'as' => 'login',
        'uses' => 'PublicController@Login',
        'middleware' => config('asgard.page.config.middleware'),
    ]);

}


//    $router->any('{uri}', [
//        'uses' => 'PublicController@uri',
//        'as' => 'page',
//        'middleware' => config('asgard.page.config.middleware'),
//    ])->where('uri', '.*');