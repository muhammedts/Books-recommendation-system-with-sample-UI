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


Route::get('/', 'DashboardController@index');
Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::post('books/{id}','booksController@rate');
Route::resource('books','booksController');
Route::get('/liveSearch','liveSearchController@index');
Route::get('/liveSearch/action','liveSearchController@action')->name('liveSearch.action');