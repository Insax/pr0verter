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

/**
 * Static routes.
 */
Route::group(['prefix' => '/', 'middleware' => 'web'], function () {
    Route::get('', 'StaticsController@index')->name('index');
    Route::get('converter', 'StaticsController@converter')->name('converter');
    Route::get('faq', 'StaticsController@faq')->name('faq');
    Route::get('contact', 'StaticsController@contact')->name('contact');
});

/*
 * Dynamic content
 */

Route::get('changelog', 'ChangelogController@index')->name('changelog');

/*
 * Routes used for converting
 */
Route::group(['prefix' => 'converter', 'middleware' => 'web'], function () {
    Route::get('progress/{guid}', 'ConverterController@progress')->name('progress');
    Route::get('show/{guid}', 'ConverterController@show')->name('show');
    Route::get('duration', 'ConverterController@duration')->name('duration');
    Route::post('convert', 'ConverterController@convert')->name('convert');
});

/*
 * Routes for file handling
 */
Route::group(['prefix' => 'file/', 'middleware' => 'throttle:200,10'], function () {
    Route::get('view/{guid}', 'ConverterController@view')->name('view');
    Route::get('download/{guid}', 'ConverterController@download')->name('download');
});

/*
 * Admin routes
 */
Route::group(['prefix' => 'admin/'], function () {
    Route::get('login', 'AdminController@login')->name('login');
});

/*
 * Test Routes
 */
//Route::get('test', 'StaticsController@test')->name('test');