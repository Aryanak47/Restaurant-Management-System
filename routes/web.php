<?php

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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// management route
Route::get('/management',function(){
    return view('management.index');
});
Route::resource('management/category','Management\CategoryController');
Route::resource('management/menu','Management\MenuController');
Route::resource('management/table','Management\TableController');

// Cashier route
Route::get('/cashier','Cashier\CashierController@index');
Route::get('/cashier/tables','Cashier\CashierController@getTable');
Route::get('/cashier/getMenuByCategory/{category_id}','cashier\CashierController@getMenuByCategory');
Route::Post("/cashier/orderFood","cashier\CashierController@orderFood");
Route::get("/cashier/getMenuByTable/{table_id}","cashier\CashierController@getMenuByTable");
Route::Post("/cashier/confirmOrder","cashier\CashierController@confirmOrder");
Route::Post("/cashier/deleteOrderItem","cashier\CashierController@deleteOrderItem");
Route::Post("/cashier/savePayment","cashier\CashierController@savePayment");
