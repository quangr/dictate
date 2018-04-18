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
use Illuminate\Http\Request;

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/user/profile', function (Request $request)    {
        //$users = \App\User::all();
        print_r($request->auth->name);
    });
    $router->get('/user/add', 'WordController@showadd');
    $router->post('/user/add', 'WordController@add');
    $router->get('/user/wordlist/{date}', 'WordController@showlist');
    $router->post('/user/delete', 'WordController@delete');
    $router->get('/user/dictate', 'WordController@dictate');
    $router->get('/generate/{word}','WordController@generate');
});
#$router->get('/', function () use ($router) {
#    return $router->app->version();
#});
$router->get('/', 'AuthController@showlogin');
$router->get('/login', 'AuthController@showlogin');
$router->post('/auth/login', 'AuthController@authenticate');
$router->get('/word/{word}', 'WordController@show');
$router->get('/list', 'WordController@showlist');
