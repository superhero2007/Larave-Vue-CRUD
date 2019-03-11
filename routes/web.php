<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->post('/', 'UserController@store');

        $router->group(['prefix' => '{id}'], function () use ($router) {
            $router->get('/', 'UserController@show');
            $router->put('/', 'UserController@update');
            $router->delete('/', 'UserController@destroy');
        });
    });
});

Route::get('/', 'SinglePageController@index')->where('any', '.*');
