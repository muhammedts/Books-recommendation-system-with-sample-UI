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
Route::resource('books','booksController');
Route::get('/liveSearch','liveSearch@index');
Route::get('/liveSearch/action','liveSearch@action')->name('liveSearch.action');