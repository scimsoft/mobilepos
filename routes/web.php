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

Route::get('/', 'HomeController@index');

Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/admin', 'HomeController@admin')->name('admin')->middleware('is_admin');

//PEDIR
    Route::get('/order/{id?}', 'OrderController@order');

    Route::post('/orderlineadd/ajax/','OrderController@addOrderLine');
    Route::get('/orderline.destroy/{id}','OrderController@destroyOrderLine') ->name('orderline.destroy');
    Route::get('/orderline/add/{id}','OrderController@addProduct')->name('order.addproduct');
    Route::get('/products/category/{id}','OrderController@getProductsFromCategory');

//CESTA
    Route::get('/total/ajax/{id}','OrderController@getOrderTotal');
    Route::get('/basket/{id}','OrderController@getBasket');

//PAGO
    Route::get('checkout','CheckOutController@index');
    Route::get('/stripe', 'StripePaymentController@index');
    Route::post('/store', 'StripePaymentController@store')->name('store');
    Route::get('/payed', 'StripePaymentController@payed')->name('payed');

//ADMIN
    //PRODUCTOS

    Route::resource('products', 'ProductController')->middleware('is_admin');



    Route::get('/products/ajax/{id}','ProductController@getAjaxProductDetails');
    Route::get('/productdetail/{id}','ProductController@editProductDetails')->middleware('is_admin');
    Route::get('/productedit/{id}','ProductController@saveProductDetails')->middleware('is_admin');

    Route::get('crop-image/{id}', 'ProductController@editImage')->middleware('is_admin');
    Route::post('crop-image', 'ProductController@imageCrop')->middleware('is_admin');

    //ORDERS
    Route::get('/orderlist','OrderAdminController@index');
    Route::get('/orderlist/setpaid/{id}','OrderAdminController@setPaid');
    Route::get('/orderlist/setready/{id}','OrderAdminController@setReady');
    Route::get('/orderlist/setfinish/{id}','OrderAdminController@finish');

//

    Route::get('/prepareorder/{id}','OrderPrintController@printKitchenOrder')->name('prepareorder');



