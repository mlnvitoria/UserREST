<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/



$router->group(['prefix' => 'api/v1'], function() use ($router) {
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });
});

$router->get('/', function () {
    return "Hi";
});
