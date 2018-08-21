<?php



Route::get('/', function () {
    return view('lughayetu.welcome');
});

Auth::routes();

Route::get('/home', 'LinetController@home')->name('home');
Route::get('/terms', 'HomeController@terms')->name('terms');
//Route::get('/test', 'HomeController@test')->name('test');
//Route::post('/test', 'HomeController@testing')->name('testing');

Route::get('/style/{name}', 'ApiController@getstyle')->name('getstyle');
Route::post('/system/{name}', 'ApiController@getscript')->name('getscript');
//Route::get('/system/{name}', 'ApiController@getscript')->name('getscript');

Route::post('/api/{endPoint}', 'ApiController@api')->name('api');
//Route::get('/api/{endPoint}', 'ApiController@api')->name('api');

Route::resource('/applications','AppsController');
Route::resource('/notifications','NotificationsController');

