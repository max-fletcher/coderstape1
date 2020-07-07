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

// Uses the test middleware found in middleware folder
Route::get('/about', function () {
    return view('about');
})->middleware('test');

Route::get('customers', 'CustomersController@index')->name('customers.index');
Route::get('customers/detailedlist', 'CustomersController@detailedlist')->name('customers.detailedlist');
Route::get('customers/create', 'CustomersController@create')->name('customers.create');
Route::post('customers', 'CustomersController@store')->name('customers.store');
// This show is using a policy called CustomerPolicy for access control. The customer model defined in route is
// sent to the policy's view method. If the view returns true(i.e matches array in this case), it allows access
// to this route
Route::get('customers/{customer}/show', 'CustomersController@show')->name('customers.show')->middleware('can:view,customer');
Route::get('customers/{customer}/edit', 'CustomersController@edit')->name('customers.edit');
Route::patch('customers/{customer}', 'CustomersController@update')->name('customers.update');
Route::delete('customers/{customer}', 'CustomersController@destroy')->name('customers.destroy');

Auth::routes();

Route::get('home', 'HomeController@index')->name('home.index');
