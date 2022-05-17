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

$router->get('/', function () {
    return app()->version();
});

$router->get('/password/reset', [
    'as' => 'password.reset', 'uses' => 'Auth\AuthController@showLinkRequestForm'
]);

$router->group([
    'prefix' => 'api/user', 'as' => 'api.user'
], function () use ($router) {
    $router->group(['namespace' => 'Auth'], function () use ($router) {
        $router->post('sign-in', ['as' => 'login', 'uses' => 'AuthController@login']);
        $router->post('register', ['as' => 'register', 'uses' => 'AuthController@register']);
        $router->post('/recover-password', ['as' => 'recover-password', 'uses' =>'AuthController@generateResetToken']);
        $router->post('/reset-password', ['as' => 'reset-password', 'uses' =>'AuthController@resetPassword']);
    });
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('companies', ['as' => 'companies', 'uses' => 'CompanyController@index']);
        $router->post('companies', ['as' => 'companies', 'uses' => 'CompanyController@store']);
        $router->get('companies/{companyId}', ['as' => 'companies', 'uses' => 'CompanyController@show']);
    });
});

