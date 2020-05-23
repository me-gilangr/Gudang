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

Route::get('/', 'Frontend\MainController@index')->name('main');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['role:Administrator']], function () {
        Route::group(['prefix' => 'Administrator'], function () {
            Route::get('/', 'Backend\MainController@index')->name('admin.main');
            Route::resource('User', 'Backend\UserController');
            Route::resource('Category', 'Backend\CategoryController');
            Route::resource('Storage', 'Backend\StorageController');
            Route::resource('Stuff', 'Backend\StuffController');    
            Route::get('StockCard/{id}', 'Backend\StockCardController@index')->name('StockCard.index');
            Route::get('/Image/Stuff/{id}', 'Backend\ImageStuffController@image')->name('ImageStuff.image');
            Route::post('/Image/Stuff/{id}', 'Backend\ImageStuffController@store')->name('ImageStuff.store');
            Route::delete('/Image/Stuff/{id}', 'Backend\ImageStuffController@delete')->name('ImageStuff.delete');

            Route::get('/Entry', 'Backend\EntryController@index')->name('Entry.index');
            Route::post('/Entry/store', 'Backend\EntryController@store')->name('Entry.store');
            Route::post('/Entry/cancel', 'Backend\EntryController@cancel')->name('Entry.cancel');
            Route::get('/Entry/data', 'Backend\EntryController@data')->name('Entry.data');

            Route::get('/Out', 'Backend\OutController@index')->name('Out.index');
            Route::post('/Out/store', 'Backend\OutController@store')->name('Out.store');
            Route::post('/Out/cancel', 'Backend\OutController@cancel')->name('Out.cancel');

            Route::get('/Adjustment', 'Backend\AdjustmentController@index')->name('Adjustment.index');
        });

        Route::group(['prefix' => 'Restore'], function () {
            Route::post('User', 'Backend\UserController@restore')->name('User.restore');
            Route::post('Category', 'Backend\CategoryController@restore')->name('Category.restore');
            Route::post('Storage', 'Backend\StorageController@restore')->name('Storage.restore');
            Route::post('Stuff', 'Backend\StuffController@restore')->name('Stuff.restore');
        });

        Route::group(['prefix' => 'Perma-Del'], function () {
            Route::post('User', 'Backend\UserController@permanent')->name('User.permanent');
            Route::post('Category', 'Backend\CategoryController@permanent')->name('Category.permanent');
            Route::post('Storage', 'Backend\StorageController@permanent')->name('Storage.permanent');
            Route::post('Stuff', 'Backend\StuffController@permanent')->name('Stuff.permanent');
        });

        Route::group(['prefix' => 'Cart'], function () {
            Route::get('Entry', 'Backend\CartController@EntryGet')->name('Cart.entry');
            Route::post('Entry/Detail', 'Backend\CartController@EntryDetail')->name('Cart.entry.detail');
            Route::post('Entry/Update', 'Backend\CartController@EntryUpdate')->name('Cart.entry.update');
            Route::post('Entry/Delete', 'Backend\CartController@EntryDelete')->name('Cart.entry.delete');
            Route::post('Entry/Store', 'Backend\CartController@EntryStore')->name('Cart.entry.store');

            Route::get('Out', 'Backend\CartController@OutGet')->name('Cart.out');
            Route::post('Out/Detail', 'Backend\CartController@OutDetail')->name('Cart.out.detail');
            Route::post('Out/Update', 'Backend\CartController@OutUpdate')->name('Cart.out.update');
            Route::post('Out/Delete', 'Backend\CartController@OutDelete')->name('Cart.out.delete');
            Route::post('Out/Store', 'Backend\CartController@OutStore')->name('Cart.out.store');
        });
    });

    Route::group(['prefix' => 'json'], function () {
        Route::get('user/trashed', 'JsonController@trashedUser')->name('json.trashed.user');
        Route::get('storage', 'JsonController@storage')->name('json.storage');
        Route::get('storage/trashed', 'JsonController@trashedStorage')->name('json.trashed.storage');
        Route::get('category', 'JsonController@category')->name('json.category');
        Route::get('category/trashed', 'JsonController@trashedCategory')->name('json.trashed.category');
        Route::get('stuff', 'JsonController@stuff')->name('json.stuff');
        Route::post('stuff/detail', 'JsonController@detailStuff')->name('json.stuff.detail');
        Route::get('stuff/trashed', 'JsonController@trashedStuff')->name('json.trashed.stuff');
    });
});