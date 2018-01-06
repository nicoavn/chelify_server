<?php

//use Illuminate\Http\Request;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'user',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/{user_id}', 'UserController@show')->name('user-show');
    Route::get('/info/{user_id}', 'UserController@info')->name('user-info');
    Route::get('{user_id}/month-summary', 'UserController@monthSummary')->name('user-month-summary');
    Route::post('/', 'UserController@store')->name('user-store');
});

Route::post('register', 'Api\AuthController@register');

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'group',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/', 'GroupController@index')->name('group-list');
    Route::post('/add-member', 'GroupController@addMember')->name('group-add-member');
});

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'transaction',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/', 'TransactionController@index')->name('transaction-list');
    Route::post('/', 'TransactionController@store')->name('transaction-store');
});

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'transaction-category',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/', 'TransactionCategoryController@index')->name('transaction-category-list');
    Route::get('/{id}', 'TransactionCategoryController@show')->name('transaction-category-show');
});

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'image',
    'namespace' => 'Api'
], function ($router) {
//    Route::get('/{image_id}', 'ImageController@show')->name('image-show');
    Route::post('/', 'ImageController@store')->name('image-store');
    Route::post('upload', 'ImageController@store')->name('image-upload');
    Route::get('show/{fileName}', 'ImageController@image')->name('image-show');
});

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth',
    'namespace' => 'Api'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'password',
    'namespace' => 'Api'
], function ($router) {
    Route::post('/reset-auth', 'PasswordController@resetAuthenticated');
});

Route::group([
    'middleware' => ['api'],
    'prefix' => 'password',
    'namespace' => 'Api'
], function ($router) {
    // Forgot
    //Route::post('email', 'PasswordController@sendResetLinkEmail')->name('api.password.email');
    //$router->get('reset', 'PasswordController@showLinkRequestForm')->name('api.password.request');
    $router->post('email', 'PasswordController@sendResetLinkEmail')->name('api.password.email');
    $router->post('reset', 'PasswordController@reset')->name('api.password.reset');

    // Reset Authenticated
    //Route::get('auth/password/reset', 'Auth\PasswordController@getResetAuthenticatedView');
});

Route::group([
    'middleware' => ['web'],
    'prefix' => 'password',
    'namespace' => 'Api'
], function ($router) {
    Route::get('reset/{token}', 'PasswordController@showResetForm')->name('api.password.reset-form');
});