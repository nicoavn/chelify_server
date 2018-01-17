<?php

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

Route::post('/register', 'Api\AuthController@register');

//
// Group
//

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'group',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/', 'GroupController@index')->name('group.list');
    Route::get('/{groupId}', 'GroupController@show')->name('group.show');
    Route::post('/', 'GroupController@store')->name('group.store');
    Route::post('/add-member', 'GroupController@addMember')->name('group.add-member');
    Route::post('/add-member-by-email', 'GroupController@addMemberByEmail')->name('group.add-member-by-email');
    Route::post('/remove-member', 'GroupController@removeMember')->name('group.remove-member');
    Route::get('/by-user/{userId}', 'GroupController@showByUser');
    Route::post('/add-contribution', 'GroupController@addContribution');
    Route::get('/{groupId}/contributions', 'GroupController@contributions')->name('group.contributions');
    Route::delete('/{groupId}', 'GroupController@destroy')->name('group.delete');
});

//
// Transaction
//

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'transaction',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/', 'TransactionController@index')->name('transaction.list');
    Route::get('/{transactionId}', 'TransactionController@show')->name('transaction.show');
    Route::get('/by-account/{accountId}', 'TransactionController@showByAccount')->name('transaction.by-account');
    Route::get('/month-summary/{accountId}', 'TransactionController@monthSummary')->name('transaction.month-summary');
    Route::get('/day-summary/{accountId}', 'TransactionController@daySummary')->name('transaction.day-summary');

    Route::post('/', 'TransactionController@store')->name('transaction.store');
    Route::put('/{transactionId}', 'TransactionController@update')->name('transaction.update');
    Route::delete('/{transactionId}', 'TransactionController@destroy')->name('transaction.delete');

});

//
// Recurrent Transaction
//

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'recurrent-transaction',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/', 'RecurrentTransactionController@index')->name('recurrent-transaction.list');
    Route::get('/{recurrentTransactionId}', 'RecurrentTransactionController@show')->name('recurrent-transaction.show');
    Route::get('/by-account/{accountId}', 'RecurrentTransactionController@showByAccount')->name('recurrent-transaction.by-account');

    Route::post('/', 'RecurrentTransactionController@store')->name('recurrent-transaction.store');
    Route::put('/{recurrentTransactionId}', 'RecurrentTransactionController@update')->name('recurrent-transaction.update');
    Route::delete('/{recurrentTransactionId}', 'RecurrentTransactionController@destroy')->name('recurrent-transaction.delete');
});

//
// Transaction Category
//

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'transaction-category',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/', 'TransactionCategoryController@index')->name('transaction-category.list');
    Route::get('/{id}', 'TransactionCategoryController@show')->name('transaction-category.show');
});

//
// Financial Instrument
//

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'financial-instrument',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/', 'FinancialInstrumentController@index')->name('financial-instrument.list');
    Route::get('/{financialInstrumentId}', 'FinancialInstrumentController@show')->name('financial-instrument.show');
    Route::get('/by-account/{accountId}', 'FinancialInstrumentController@showByAccount')->name('financial-instrument.by-account');
    Route::post('/', 'FinancialInstrumentController@store')->name('financial-instrument.store');
});

//
// Report
//

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'report',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/', 'ReportController@index')->name('report.list');
    Route::get('/build', 'ReportController@build')->name('report.build');
    Route::get('/{reportId}', 'ReportController@show')->name('report.show');
    Route::get('/{reportId}/build', 'ReportController@buildById')->name('report.build-by-id');
    Route::get('/by-account/{accountId}', 'ReportController@showByAccount');
    Route::post('/', 'ReportController@store')->name('report.store');
});

//
// Image
//

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'image',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/{imageId}', 'ImageController@show')->name('image.image-show');
    Route::post('/upload', 'ImageController@upload')->name('image.upload');
    Route::get('/show/{fileName}', 'ImageController@image')->name('image.show');
    Route::get('/by-account/{accountId}', 'ImageController@showByAccount')->name('image.by-account');
});

//
// Security and Authentication
//

//
// User
//

Route::group([
    'middleware' => ['api'], //, 'auth:api'
    'prefix' => 'user',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/{userId}', 'UserController@show')->name('user.show');
});

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth',
    'namespace' => 'Api'
], function ($router) {
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/me', 'AuthController@me');
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
    Route::post('/email', 'PasswordController@sendResetLinkEmail')->name('api.password.email');
    Route::post('/reset', 'PasswordController@reset')->name('api.password.reset');

    // Reset Authenticated
    //Route::get('auth/password/reset', 'Auth\PasswordController@getResetAuthenticatedView');
});

Route::group([
    'middleware' => ['web'],
    'prefix' => 'password',
    'namespace' => 'Api'
], function ($router) {
    Route::get('/reset/{token}', 'PasswordController@showResetForm')->name('api.password.reset-form');
});