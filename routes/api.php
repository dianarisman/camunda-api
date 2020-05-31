<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


    $router->post('taskStart', 'camundaController@TaskStart');
    $router->post('taskList', 'camundaController@TaskList');
    $router->post('taskComplate', 'camundaController@TaskComplate');

    //task yg sudah digabungin
    $router->post('task', 'camundaController@Task');

