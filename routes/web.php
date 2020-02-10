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


Route::get('/', function () {
    //  home page route : /
    return view('welcome');
});

Route::get('/about', function () {
    return view("pages/about");
});
*/
//dinamik route:
/*
Route::get('/user/{id}/{name}', function ($id,$name) {
    return "this is user $name  with id: ".$id;
});
*/


Route::get('/', "PagesController@index");
Route::get('/about', "PagesController@about");
Route::get('/services', "PagesController@services");


Auth::routes();

//Route::get('/', "PagesController@index");
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user_{id}/timeline', 'HomeController@showTimeline');
Route::get('/profile/edit-{part}', 'HomeController@edit');
Route::put('/profile/edit-basic', 'HomeController@update');

Route::get('/timeline-about', function () {
    return view("pages/about"); //temp
});


Route::resource('posts','PostController');
