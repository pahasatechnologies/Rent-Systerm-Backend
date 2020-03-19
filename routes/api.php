<?php

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

Route::group([
    'prefix' => 'auth',
], function ($router) {
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('refresh', 'Api\AuthController@refresh');
});
Route::group([
    'prefix' => 'profile',
], function ($router) {
    Route::get('me', 'Api\AuthController@me');
    Route::get('profile', 'Api\ProfileController@index');
    Route::post('change-password', 'Api\ProfileController@changePassword');
    Route::post('save-user', 'Api\ProfileController@saveUser');
    Route::post('save-profile', 'Api\ProfileController@saveProfile');
    Route::post('save-social', 'Api\ProfileController@saveSocial');
    Route::post('save-image', 'Api\ProfileController@saveImage');
});

// Route::get('listings', 'Api\ListingController@index');
// Route::get('listings/{id}', 'Api\ListingController@show');
// Route::post('listings', 'Api\ListingController@store');

Route::get('listings/search', 'Api\ListingController@search')->name('listings.seach');
Route::delete('listings/{listing}/remove-file/{id}', 'Api\ListingController@removeFile')->name('listings.removefile');
Route::get('listings/user-listings', 'Api\ListingController@user_listings')->name('listings.userlistings');
Route::get('listings/locations', 'Api\ListingController@locations')->name('listings.locations');
Route::resource('listings', 'Api\ListingController')->only(['index', 'show', 'store']);
Route::post('listings/{listing}', 'Api\ListingController@update')->name('listings.update');
Route::post('listings/{listing}/ratings', 'Api\ListingController@ratings')->name('ratings.save');
Route::resource('ratings', 'Api\RatingController')->only(['destroy', 'update']);
Route::resource('categories', 'Api\CategoryController')->only(['index']);
