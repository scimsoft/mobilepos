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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/productdetail/{id}','ProductController@editProductDetails');
    Route::get('/productedit/{id}','ProductController@saveProductDetails');
    Route::get('/order', 'OrderController@index')->name('home');
    Route::get('/products/ajax/{id}','ProductController@getAjaxProductDetails');
    Route::get('/total/ajax/{id}','OrderController@getOrderTotal');
    Route::get('/basket/{id}','OrderController@getBasket');



    Route::post('/orderlineadd/ajax/','OrderController@addOrderLine');
    Route::get('/orderline.destroy/{id}','OrderController@destroyOrderLine') ->name('orderline.destroy');

    Route::get('crop-image/{id}', 'ProductController@editImage');
    Route::post('crop-image', 'ProductController@imageCrop');

    Route::resource('products', 'ProductController');

    Route::get('checkout','CheckoutController@index');

Route::get('/stripe', 'MyStripeController@index');
Route::post('/store', 'MyStripeController@store')->name('store');



