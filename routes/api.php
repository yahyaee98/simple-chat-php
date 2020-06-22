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

$router->get('/', function () use ($router) {
    return sprintf('%s (#%s)', config('app.name'), config('app.version'));
});


$router->group([
    'middleware' => 'auth',
    'prefix' => 'v1',
], static function () use ($router): void {
    $router->group([
        'middleware' => 'auth',
    ], static function () use ($router): void {
        $router->get('/inbox', 'ChatController@getInbox');
        $router->post('/messages', 'ChatController@postMessage');
    });

    $router->post('/users', 'UserController@register');
});

