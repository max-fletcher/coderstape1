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
    return view('landingpage');
});

Route::get('/contact', 'ContactFromController@create')->name('contact.create');
Route::post('/contact', 'ContactFromController@store')->name('contact.store');

Route::get('/about', function () {
    return view('about');
})->middleware('test');

Route::get('/customers', 'CustomersController@index');
Route::get('/customers/detailedlist', 'CustomersController@detailedlist');
Route::get('/customers/create', 'CustomersController@create');
Route::post('/customers', 'CustomersController@store')->name('customers.store');
Route::get('/customers/{customer}/show', 'CustomersController@show');
Route::get('/customers/{customer}/edit', 'CustomersController@edit');
Route::patch('/customers/{customer}', 'CustomersController@update')->name('customers.update');
Route::delete('/customers/{customer}', 'CustomersController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home.index');
