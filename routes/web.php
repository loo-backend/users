<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', 'UsersController@index');
    $router->post('/', 'UsersController@store');
    $router->get('/{user}', 'UsersController@show');
    $router->put('/{user}', 'UsersController@update');
    $router->delete('/{user}', 'UsersController@destroy');
});