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

// Create account
Route::post('/register', [
    'uses'  => 'AuthController@createUser',
    'as'    => 'create-user'
]);

Route::get('/users', [
    'uses'  => 'AuthController@getUsers',
    'as'    => 'get-users'
]);

// Login
Route::post('/login', [
    'uses'  => 'AuthController@login',
    'as'    => 'login-user'
]);

// Logout
Route::get('/logout', [
    'uses' => 'AuthController@logout',
    'as' => 'logout-user'
])->middleware('auth:api');

// Password reset link request routes...
Route::post('password/email', [
    'uses' => 'AuthController@createTokenResetPassword',
    'as' => 'get-password-reset-link'
]);
Route::post('password/email-link', [
    'uses' => 'AuthController@sendTokenResetPasswordLink',
    'as' => 'send-password-reset-link'
]);

// Password reset routes...
Route::post('password/reset', 'AuthController@resetPassword');

