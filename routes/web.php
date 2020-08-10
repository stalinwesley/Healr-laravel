<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', 'Admin\LoginController@index')->name('login');
Route::post('post-login', 'Admin\LoginController@postLogin')->name('postlogin'); 
Route::get('register', 'Admin\LoginController@register')->name('register');
Route::post('post-register', 'Admin\LoginController@postRegister')->name('postregister'); 
Route::get('dashboard', 'Admin\DashBoardController@dashboard')->name('dashboard'); 

Route::post('logout', 'Admin\LoginController@logout')->name('logout');
Route::get('addngo', 'Admin\DashBoardController@addngo')->name('addngo');
Route::post('addngo', 'Admin\DashBoardController@getpostngo')->name('postaddngo');
});


Route::prefix('ngo')->name('ngo.')->group(function () {
    Route::get('login', 'NGO\NGOController@index')->name('login');
Route::post('post-login', 'NGO\NGOController@postLogin')->name('postlogin'); 
Route::get('register', 'NGO\NGOController@register')->name('register');
Route::post('post-register', 'NGO\NGOController@postRegister')->name('postregister'); 
Route::get('dashboard', 'NGO\DashBoardController@dashboard')->name('dashboard'); 

Route::post('logout', 'NGO\NGOController@logout')->name('logout');
Route::get('healthworker', 'NGO\DashBoardController@healthworker')->name('healthworker');
Route::post('healthworker', 'NGO\DashBoardController@posthealthworker')->name('posthealthworker');
});

