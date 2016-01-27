<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/buy-gift-cards', 'ListingController@getAllListings');
    Route::get('/buy-{brand}-gift-cards', 'ListingController@getListing')
		->where('brand', '[A-Za-z-]+');
    Route::get('/gift-card-listings', 'ListingController@getListing');

    Route::post('/cart/add', 'CartController@add');
    Route::post('/cart/delete', 'CartController@delete');
    Route::post('/cart/discard', 'CartController@discard');
    Route::get('/cart', 'CartController@index');

    Route::post('/purchase', 'PurchaseController@done');
});

Route::group(['middleware' => ['web', 'auth']], function () {
   // Route::auth();
    Route::get('/sell-gift-card', 'SellController@getAddCard');
    Route::post('/sell-gift-card', 'SellController@postAddCard');
    Route::post('/check-gift-card-balance', 'SellController@postCheckBalance');

	Route::post('/reset-pin', 'ResetPinController@postReset');
	
    Route::get('/user/profile', 'UserController@getProfile');
    Route::get('/user/cards', 'UserController@getMyCards');
	Route::get('/user/purchased-cards', 'UserController@purchasedCards');
});
