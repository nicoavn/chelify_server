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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', 'ApiAuthController@register');

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'group'
], function ($router) {
    Route::get('/', 'GroupController@index')->name('group-list');
    Route::post('/add-member', 'GroupController@addMember')->name('group-add-member');
});

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'transaction'
], function ($router) {
    Route::get('/', 'TransactionController@index')->name('transaction-list');
});

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'transaction-category'
], function ($router) {
    Route::get('/', 'TransactionCategoryController@index')->name('transaction-category-list');
    Route::get('/{id}', 'TransactionCategoryController@show')->name('transaction-category-show');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'ApiAuthController@login');
    Route::post('logout', 'ApiAuthController@logout');
    Route::post('refresh', 'ApiAuthController@refresh');
    Route::post('me', 'ApiAuthController@me');
});

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'image'
], function ($router) {
    Route::get('/{account_id}', 'ImageController@show')->name('image-show');
    Route::post('/', 'ImageController@store')->name('image-store');
});