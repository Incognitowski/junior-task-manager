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

Route::group(['prefix'=>'api'], function(){

    Route::group(['prefix'=>'tasks'], function(){
        Route::get('/', 'API\TaskController@getAll');
        Route::get('/{task}', 'API\TaskController@find');
        Route::post('/', 'API\TaskController@create');
        Route::put('/{task}', 'API\TaskController@update');
        Route::delete('/{task}', 'API\TaskController@delete');
    });

    Route::group(['prefix'=>'users'], function(){
        Route::get('/', 'API\UserController@getAll');
        Route::get('/{user}', 'API\UserController@find');
        Route::post('/', 'API\UserController@create');
        Route::put('/{user}', 'API\UserController@update');
        Route::delete('/{user}', 'API\UserController@delete');
    });

});

Route::redirect('/', 'tasks');
Route::get('/users', 'UserController@page');
Route::get('/tasks', 'TaskController@page');
