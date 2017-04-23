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
})->name('welcome');

Route::get('converter', function () {
    return view('converter/home');
})->name('converter');

Route::get('faq', function () {
    return view('faq/home');
})->name('faq');

Route::get('contact', function () {
    return view('contact/home');
})->name('contact');

Route::post('convert', 'ConverterController@upload')->name('upload');
Route::get('progress/{guid}', 'ConverterController@progress')->name('progress');
Route::get('show/{guid}', 'ConverterController@show')->name('show');
Route::get('view/{guid}', 'ConverterController@view')->name('view');
Route::get('download/{guid}', 'ConverterController@download')->name('download');
Route::get('duration', 'ConverterController@duration')->name('duration');
Route::get('delete', 'ConverterController@delete')->name('delete');
Route::get('changelog', 'ChangelogController@index')->name('changelog');
Route::get('test', 'ConverterController@test')->name('test');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
