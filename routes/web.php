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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tweets', 'TweetsController@index')->name('list_tweets');
Route::post('/block_user', 'BlockedUserController@store');
Route::post('/promote_user', 'PromotedUserController@store');
Route::get('/blocked-users', 'BlockedUserController@index')->name('blocked_users');
Route::get('/promoted-users', 'PromotedUserController@index')->name('promoted_users');
Route::get('/blocked-keywords', function() {
    $keywords = DB::table('filtered_keywords')->get();
    return view('keywords.index', compact('keywords'));
})->name('blocked_keywords');

