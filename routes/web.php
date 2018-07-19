<?php



Route::get('/', function () {
    return view('lughayetu.home');
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'LinetController@index')->name('home');
Route::get('/terms', 'HomeController@terms')->name('terms');
