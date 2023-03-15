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

Route::get('/', 'App\Http\Controllers\PdfController@index')->name('pdf.list');
Route::get('/pdf-add', 'App\Http\Controllers\PdfController@add')->name('pdf.add');
Route::post('/pdf-upload', 'App\Http\Controllers\PdfController@upload')->name('pdf.upload');
Route::get('/pdf-view/{file?}/{type?}', 'App\Http\Controllers\PdfController@view')->name('pdf.view');