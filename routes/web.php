<?php



Route::get('/', function () {
    return view('lughayetu.welcome');
});

Auth::routes();

Route::get('/home', 'LinetController@home')->name('home');
Route::get('/terms', 'HomeController@terms')->name('terms');

Route::get('/style/{name}', 'HomeController@getstyle')->name('getstyle');
Route::get('/system/{name}', 'HomeController@getscript');
Route::post('/system/{name}', 'HomeController@getscript')->name('getscript');

Route::post('/api/{endPoint}', 'ApiController@api')->name('api');

Route::resource('/applications','AppsController');
Route::resource('/notifications','NotificationsController');

Route::post('/wenzangu/{api}', 'FriendsController@api')->name('friends');

Route::resource('/ujumbe', 'MessageController');
Route::post('/ujumbe/chats/{username}', 'MessageController@chats')->name('chats');

Route::get('/profile', 'ProfileController@show')->name('profile');
Route::post('/profile', 'ProfileController@update_avatar');