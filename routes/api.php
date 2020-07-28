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
    // Route::post('forgot-password-reset', 'Auth\ResetPasswordController@reset');
});

Route::middleware(['auth:api'])->group(function () {
    // Email Verification Routes...
    // Route::post('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
    // Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    // Route::post('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
});


// Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
// Route::post('password/reset', 'Api\ResetPasswordController@reset');

Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Api\ResetPasswordController@resetPassword');
// Route::get('email/resend', 'Api\VerificationController@resend')->name('verification.resend');
// Route::get('email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');

// Email Verification Routes...
Route::get('email/verify', 'Api\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Api\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Api\VerificationController@resend')->name('verification.resend');

Route::group([
    'prefix' => 'profile',
    'middleware' => 'verified'
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
Route::get('listings/top_data', 'Api\ListingController@top')->name('listing.top');
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
Route::post('listings/{listing}/set-featured', 'Api\ListingController@setFeatured')->name('listings.set_featured');
Route::post('listings/{listing}/set-status', 'Api\ListingController@setActiveStatus')->name('listings.set_status');
Route::delete('listings/{listing}/bookmarks/remove', 'Api\ListingController@remove_bookmark')->name('ratings.remove_bookmark');
Route::resource('ratings', 'Api\RatingController')->only(['destroy', 'update']);
Route::resource('categories', 'Api\CategoryController')->only(['index', 'show', 'store', 'update', 'destroy']);

Route::post('subscriptions/create', 'Api\SubscribersController@create')->name('Subscribers.create');
Route::post('contact-us', 'Api\ContactController@sendMail');

Route::group([
    'prefix' => 'admin',
], function ($router) {
    Route::get('dashboard', 'Api\AdminController@dashboard');
    Route::get('listings', 'Api\AdminController@listings');
    Route::get('subscribers', 'Api\SubscribersController@subscribers');
    Route::post('subscribers/{subscriber}', 'Api\SubscribersController@change_status');
    Route::delete('subscribers/{subscriber}', 'Api\SubscribersController@remove_subscriber');
    Route::get('users', 'Api\AdminController@users');
    Route::get('users/search', 'Api\AdminController@users_search');
    Route::get('listings/user-listings/{user}', 'Api\AdminController@user_listings');
    Route::put('listings/{listing}/change-user', 'Api\AdminController@change_user');
});;

