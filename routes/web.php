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

use Illuminate\Support\Facades\DB;

Auth::routes();

Route::get('/', 'BookingController@welcome')->name('welcome');

Route::get('/home', 'HomeController@home')->name('home');
Route::get('/new', 'BookingController@new_booking')->name('new');
Route::post('/new', 'BookingController@post_booking');
Route::get('/book_now/{id}','BookingController@book_now')->name('book_now');
Route::post('/book_now/{id}', 'BookingController@post_booking');

Route::get('show_by_months/{month}', 'BookingController@show_by_months')->name('month')->middleware('role:booker');

Route::middleware('auth')->group(function () {

    Route::get('/show_bookings/{id}', 'BookingController@show_bookings')->name('show_bookings');

    Route::get('/show_by_date/{date}', 'BookingController@show_by_date')->name('show_by_date');

    Route::get('/edit_booking/{id}', 'BookingController@edit_booking')->name('edit_booking');
    Route::post('/edit_booking/{id}', 'BookingController@update_booking');

    Route::get('/delete_booking/{id}', 'BookingController@delete_booking')->name('delete_booking');

});

Route::get('/show_all', 'AdminController@show_all')->name('show_all');

Route::get('/tour/{id}', 'AdminController@tour')->name('tour');

Route::get('/edit_tour/{id}', 'AdminController@edit_tour')->name('edit_tour');
Route::post('/edit_tour/{id}', 'AdminController@update_tour');

Route::get('/cancel_tour/{id}', 'AdminController@cancel_tour')->name('cancel_tour');
Route::get('/restore_tour/{id}', 'AdminController@restore_tour')->name('restore_tour');

Route::get('date_tours', 'AdminController@date_tours')->name('tours');

Route::get('date_guide/{date?}', 'AdminController@date_guide')->name('date_guide');
Route::post('/guides/{date}', 'AdminController@set_guides')->name('guides');

Route::get('/guide/{id}', 'AdminController@guide_tours')->name('guide');

Route::get('/set_tours', 'AdminController@set_tours')->name('set_tours');
Route::post('/set_tours', 'AdminController@create_tours');

Route::get('/delete_tour/{id}', 'AdminController@delete_tour')->name('delete_tour');

Route::get('/new_guide', 'AdminController@new_guide')->name('new_guide');
Route::post('/new_guide', 'AdminController@add_guide');

Route::get('/delete_guide/{id}', 'AdminController@delete_guide')->name('delete_guide');

Route::get('/booker_details', 'AdminController@booker_details')->name('booker_details');
Route::get('/get_details', 'AdminController@get_details')->name('get_details');

Route::get('/new_item', 'AdminController@new_item')->name('new_item');
Route::post('/new_item', 'AdminController@add_item');
