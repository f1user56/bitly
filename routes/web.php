<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group([
    'namespace' => 'Web'
], function($router) {
    $router->get('/',['as' => 'MainController', 'uses' => 'MainController@view']);
    $router->get('/{short}',['as' => 'RedirectToOriginal', 'uses' => 'MainController@redirect']);
});



