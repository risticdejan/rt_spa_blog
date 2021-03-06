<?php

use Illuminate\Http\Request;

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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('signin', 'AuthController@login');
    Route::post('signout', 'AuthController@logout');
    Route::post('signup', 'AuthController@signup');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('user', 'AuthController@user');
});


Route::apiResource('/post', 'PostController');
Route::get('/user/{user}/posts', 'PostController@byUser');

Route::get('/category', 'CategoryController@index');
Route::get('/category/{category}/posts', 'CategoryController@posts');