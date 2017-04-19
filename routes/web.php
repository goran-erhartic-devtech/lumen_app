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

/*
 * Index page
 */
$app->get('/', function () use ($app) {
    return $app->environment();
});

/*
 * User routes
 */
$app->get('/users', 'UserController@index');
$app->post('/user', 'UserController@createUser');

/*
 * Employee routes
 */
$app->get('/employees', 'EmployeeController@getAll');
$app->get('/employee/{id}', 'EmployeeController@getOne');
$app->post('/employee', 'EmployeeController@create');
$app->delete('/employee/{id}', 'EmployeeController@delete');
$app->put('/employee/{id}', 'EmployeeController@update');
