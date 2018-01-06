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

Route::get('/', function () {
    //$users = factory(App\User::class, 5)->create();
    //$transactions = factory(App\Transaction::class, 50)->create();
    //dd($transactions);

    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
