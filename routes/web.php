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
$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');
$router->get('/users/{id}', 'UserController@show');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@destroy');


$router->options('/{any:.*}', function () {
    return response('', 200);
});

$router->get('/me', ['middleware' => 'auth', function () {
    return auth()->user();
}]);

// Authentication routes
$router->post('/login', 'AuthController@login');
// Forgot Password (simulation)
$router->post('/forgot-password', 'AuthController@forgotPassword');
// Reset Password (simulation)
$router->post('/reset-password', 'AuthController@resetPassword');