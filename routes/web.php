<?php

use App\Http\Controllers\Admin\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

/* Route::get('/', function () {
    return view('welcome');
});
 */

Auth::routes();

Route::get('/', function () {
    return view("guest.home");
})->name('front.home');

Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('apartment', 'ApartmentController')->parameters([
        'apartment' => 'apartment:slug'
    ]);

    Route::resource('apartments.images', 'ImageController')->only(['index', 'destroy'])->parameters([
        'apartments' => 'apartment:slug']);

    Route::get('apartment/{apartment}/publicity', 'PaymentController@select')->name('publicity.index');
    Route::get('apartment/{apartment}/publicity/{publicity}', 'PaymentController@take')->name('publicity.edit');
    Route::post('apartment/{apartment}/publicity/{publicity}/checkout', 'PaymentController@checkout')->name('publicity.checkout');
});

Route::post('message/create', 'MessageController@store');

Route::get("{any?}", function () {
    return view("guest.home");
})->where("any", ".*");