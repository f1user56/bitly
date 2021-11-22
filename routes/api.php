<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group([
    'prefix' => 'api',
    'namespace' => 'Api'
], function($router) {
    $router->post('/shortlink',['as' => 'ShortLinkController', 'uses' => 'ShortLinkController@short']);
});

