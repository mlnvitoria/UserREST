<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/



$router->group(['prefix' => '/api/v1'], function() use ($router) {

    $router->group(['prefix' => '/user'], function() use ($router) {
        $router->post('/', 'UserController@store');

        $router->group(['middleware' => 'auth'], function() use ($router) {
            $router->get('/{id}', 'UserController@show');
            $router->put('/{id}', 'UserController@update');
            $router->delete('/{id}', 'UserController@delete');
        });
    });

    $router->group(['prefix' => '/customer', 'middleware' => 'auth'], function() use ($router) {
        $router->get('/', 'CustomerController@index');
        $router->get('/{id}', 'CustomerController@show');
        $router->post('/', 'CustomerController@store');
        $router->put('/{id}', 'CustomerController@update');
        $router->delete('/{id}', 'CustomerController@delete');
    });
});
