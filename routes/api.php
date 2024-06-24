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

// vimerson health
Route::prefix('vimerson')->group(function () {
    Route::post('create/user', 'VimersonHealthController@storeUser');
    Route::post('add/feedback', 'VimersonHealthController@addFeedback');
    Route::post('add/qualified/bottles', 'VimersonHealthController@addQualifiedBottles');
    Route::post('step/form/timetracker', 'VimersonHealthController@stepFormTimeTracker');
    Route::post('amazon/order_details', 'VimersonHealthController@amazonOrderDetails');
    Route::post('amazon/item_details', 'VimersonHealthController@amazonProducdDetailsByID');
    Route::post('step/details', 'VimersonHealthController@getStepDetails');
    Route::post('create/order', 'VimersonHealthController@createOrder');
    Route::get('get/featured/bottles', 'VimersonHealthController@getFeaturedBottles');
    Route::post('get/bottles/by/asin', 'VimersonHealthController@getBottleByAsin');
    Route::get('get/featured/questionnaire', 'VimersonHealthController@getFeaturedQuestionnaire');
    Route::post('send/email', 'VimersonHealthController@sendEmail');
    Route::post('bottle/to/qualify', 'VimersonHealthController@getBottleToQualify');
    Route::post('bottle/by/asin', 'AdminVimersonHealthController@getBottleByAsin');
    Route::post('bottle/images', 'AdminVimersonHealthController@getBottleImagesByAsin');

    Route::post('send/form/tracker/email', 'VimersonHealthController@sendFormTrackerEmail');
    
    Route::post('handle/amazon/popup', 'AdminVimersonHealthController@handleAmazonPopup');
    Route::get('get/amazon/popup/status', 'AdminVimersonHealthController@getAmazonPopupStauts');

    Route::post('create/shopify/order', 'VimersonHealthController@createShopifyOrder');

    Route::post('test/email', 'VimersonHealthController@testEmail');

    Route::post('delete/bottle', 'AdminVimersonHealthController@deleteSingleBottle');
    Route::post('delete/product', 'AdminVimersonHealthController@deleteSingleProduct');
});