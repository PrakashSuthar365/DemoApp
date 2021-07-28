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
use App\Http\Controllers\ProductAjaxController;


Route::get('/', function () {
    return view('welcome');
});

// Auth URLS
Auth::routes();

// Product CRUD URLS
Route::resource('ajaxproducts',ProductAjaxController::class);

// Home & Google Login URLS
Route::get('google', [App\Http\Controllers\SocialiteAuthController::class, 'googleRedirect'])->name('auth/google');
Route::get('/auth/google-callback', [App\Http\Controllers\SocialiteAuthController::class, 'loginWithGoogle']);
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

// Theme Demo URLS
Route::group(['middleware' => 'auth'], function () {
	
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');

	Route::delete('/delete-user/{id}', 'App\Http\Controllers\HomeController@delete');
	Route::get('/block-user/{id}', 'App\Http\Controllers\HomeController@block');
});

// THEME URLS
Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

