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
Route::post('books/review','reviewController@index');
Route::post('books/rate','booksController@rate');
Route::resource('books','booksController');
Route::get('/liveSearch','LiveSearchController@index');
Route::post('/liveSearchForm','LiveSearchController@indexForm');
