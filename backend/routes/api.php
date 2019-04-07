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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [
    'uses'  => 'AuthController@createUser',
    'as'    => 'create-user'
]);

Route::get('/users', [
    'uses'  => 'AuthController@getUsers',
    'as'    => 'get-users'
]);

Route::post('/login', [
    'uses'  => 'AuthController@login',
    'as'    => 'login-user'
]);

// Route::get('/logout', [
//     'uses'  => 'AuthController@logoutUser',
//     'as'    => 'logout-user'
// ]);

Route::get('/logout', [
    'uses' => 'AuthController@logout',
    'as' => 'logout-user'
])->middleware('auth:api');