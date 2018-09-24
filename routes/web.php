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

Route::get('/', 'PageController@plugins');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/dashboard', 'PageController@dashboard');

Route::prefix('dashboard')->group(function () {
    Route::resource('/plugins', 		'PluginController');
    Route::resource('/categories', 		'CategoryController');
    Route::resource('/pluginfunctions', 'PluginFunctionController');
    Route::get('/vsrepo',               'VsrepoController@list');
    Route::get('/vsrepo/{id}/generate', 'VsrepoController@generate');
});

Route::get('/plugins', 	            'PageController@plugins');
Route::get('/plugins/{id_slug}', 	'PageController@show');
#Route::get('/plugins/{namespace}', 	'PluginController');
#Route::get('/plugins/{post}', 	'PluginController@show');
