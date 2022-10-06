<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Creazione rotte 
Route::get('apartments', 'API\ApartmentController@index');
Route::get('services', 'API\ServiceController@index');
Route::get('search', 'API\ApartmentController@search');
Route::get('apartments/{apartment:slug}', 'API\ApartmentController@show');
Route::get('apartment/publicity','API\ApartmentController@apartmentPublicity');