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

Route::get('listings/latest_data', 'Api\ListingController@latest')->name('listing.latest');
Route::get('listings/search', 'Api\ListingController@search')->name('listings.seach');
Route::delete('listings/{listing}/remove-file/{id}', 'Api\ListingController@removeFile')->name('listings.removefile');
Route::get('listings/user-listings', 'Api\ListingController@user_listings')->name('listings.userlistings');
Route::get('listings/locations', 'Api\ListingController@locations')->name('listings.locations');
Route::resource('listings', 'Api\ListingController')->only(['index', 'show', 'store', 'destroy']);
Route::post('listings/{listing}', 'Api\ListingController@update')->name('listings.update');
Route::post('listings/{listing}/ratings', 'Api\ListingController@ratings')->name('ratings.save');
Route::get('listings/bookmarks/list', 'Api\ListingController@get_bookmarks')->name('ratings.get_bookmarks');
Route::get('listings/{listing}/is_bookmarked', 'Api\ListingController@is_bookmarked')->name('ratings.is_bookmarked');
Route::post('listings/{listing}/bookmarks/add', 'Api\ListingController@add_bookmark')->name('ratings.add_bookmark');
Route::delete('listings/{listing}/bookmarks/remove', 'Api\ListingController@remove_bookmark')->name('ratings.remove_bookmark');
Route::resource('ratings', 'Api\RatingController')->only(['destroy', 'update']);
Route::resource('categories', 'Api\CategoryController')->only(['index']);


Route::group([
    'prefix' => 'admin',
], function ($router) {
    Route::get('dashboard', 'Api\AdminController@dashboard');
    Route::get('listings', 'Api\AdminController@listings');
    Route::get('users', 'Api\AdminController@users');
    Route::get('listings/user-listings/{user}', 'Api\AdminController@user_listings');
});;

