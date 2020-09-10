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
    return view('layouts.frontend');
});
Route::get('/category/{slug}', function () {
    return view('layouts.frontend');
});

Route::get('/detail/{slug}', function () {
    return view('layouts.frontend');
});
Route::get('/contact', function () {
    return view('layouts.frontend');
});


Auth::routes();

Route::get('admin', 'HomeController@index')->name('home');
Route::get('admin/home', 'HomeController@index')->name('home');

Route::get('admin/{path}', 'HomeController@index')->where('path', '[A-Za-z]+?');
Route::get('admin/{path}/{path2}', 'HomeController@index')->where(['path' => '[A-Za-z]+?', 'path2' => '[A-Za-z]+?'] );
