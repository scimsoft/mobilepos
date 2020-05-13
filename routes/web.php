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

Route::view('/', 'home');

Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

//PEDIR
    Route::get('/order', 'OrderController@index');
    Route::post('/orderlineadd/ajax/','OrderController@addOrderLine');
    Route::get('/orderline.destroy/{id}','OrderController@destroyOrderLine') ->name('orderline.destroy');
    Route::get('/orderline/add/{id}','OrderController@addProduct')->name('order.addproduct');
    Route::get('/products/category/{id}','OrderController@getProductsFromCategory');

//CESTA
    Route::get('/total/ajax/{id}','OrderController@getOrderTotal');
    Route::get('/basket/{id}','OrderController@getBasket');

//PAGO
    Route::get('checkout','CheckOutController@index');
    Route::get('/stripe', 'MyStripeController@index');
    Route::post('/store', 'MyStripeController@store')->name('store');


//PRODUCTOS

    Route::resource('products', 'ProductController')->middleware('is_admin');



    Route::get('/products/ajax/{id}','ProductController@getAjaxProductDetails');
    Route::get('/productdetail/{id}','ProductController@editProductDetails')->middleware('is_admin');
    Route::get('/productedit/{id}','ProductController@saveProductDetails')->middleware('is_admin');

    Route::get('crop-image/{id}', 'ProductController@editImage')->middleware('is_admin');
    Route::post('crop-image', 'ProductController@imageCrop')->middleware('is_admin');





