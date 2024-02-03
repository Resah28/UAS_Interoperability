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
    return $router->app->version();
});
$router->group(['middleware' => ['auth']], function ($router) {
    $router->get('/auth/admin/trains', 'TrainController@index');
    $router->get('/auth/admin/train/{slug}', 'TrainController@show');
    $router->post('/auth/admin/trains', 'TrainController@store');
    $router->put('/auth/admin/train/{slug}', 'TrainController@update');
    $router->delete('/auth/admin/train/{slug}', 'TrainController@destroy');

    $router->get('/auth/admin/stations', 'StationController@index');
    $router->get('/auth/admin/station/{slug}', 'StationController@show');
    $router->post('/auth/admin/stations', 'StationController@store');
    $router->put('/auth/admin/station/{slug}', 'StationController@update');
    $router->delete('/auth/admin/station/{slug}', 'StationController@destroy');

    $router->get('/auth/admin/schedules', 'ScheduleController@index');
    $router->get('/auth/admin/schedule/{id}', 'ScheduleController@show');
    $router->post('/auth/admin/schedules', 'ScheduleController@store');
    $router->put('/auth/admin/schedule/{id}', 'ScheduleController@update');
    $router->delete('/admin/schedule/{id}', 'ScheduleController@destroy');

    $router->get('/auth/admin/tickets', 'TicketController@index');
    $router->get('/auth/admin/ticket/{id}', 'TicketController@show');
    $router->post('/auth/admin/tickets', 'TicketController@store');
    $router->put('/auth/admin/ticket/{id}', 'TicketController@update');
    $router->delete('/auth/admin/ticket/{id}', 'TicketController@destroy');

    $router->get('/auth/user/tickets', 'PublicTicketController@index');
    $router->get('/auth/user/ticket/{id}', 'PublicTicketController@show');

    $router->get('/auth/admin/users', 'UserController@index');
    $router->get('/auth/admin/user/{id}', 'UserController@show');
    $router->post('/auth/admin/users', 'UserController@store');
    $router->put('/auth/admin/user/{id}', 'UserController@update');
    $router->delete('/auth/admin/user/{id}', 'UserController@destroy');
    $router->patch('/auth/admin/user/{id}', 'UserController@updatePicture');

    $router->get('/auth/user/orders', 'PublicOrderController@index');
    $router->get('/auth/user/order/{id}', 'PublicOrderController@show');
    $router->post('/auth/user/orders', 'PublicOrderController@store');
    $router->put('/auth/user/order/{id}', 'PublicOrderController@update');
    $router->delete('/auth/user/order/{id}', 'PublicOrderController@destroy');

    $router->get('/auth/admin/orders', 'OrderController@index');
    $router->get('/auth/admin/order/{id}', 'OrderController@show');
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/registration', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->post('/passwordverify/{email}', 'AuthController@sendMail');
    $router->post('/password/forgot', 'AuthController@forgot');
    $router->put('/password/new/{id}', 'AuthController@newPass');
});
