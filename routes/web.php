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
        });

        Route::group(['prefix' => 'Restore'], function () {
            Route::post('User', 'Backend\UserController@restore')->name('User.restore');
            Route::post('Category', 'Backend\CategoryController@restore')->name('Category.restore');
            Route::post('Storage', 'Backend\StorageController@restore')->name('Storage.restore');
        });

        Route::group(['prefix' => 'Perma-Del'], function () {
            Route::post('User', 'Backend\UserController@permanent')->name('User.permanent');
            Route::post('Category', 'Backend\CategoryController@permanent')->name('Category.permanent');
            Route::post('Storage', 'Backend\StorageController@permanent')->name('Storage.permanent');
        });
    });

    Route::group(['prefix' => 'json'], function () {
        Route::get('user/trashed', 'JsonController@trashedUser')->name('json.trashed.user');
        Route::get('storage', 'JsonController@storage')->name('json.storage');
        Route::get('storage/trashed', 'JsonController@trashedStorage')->name('json.trashed.storage');
        Route::get('category', 'JsonController@category')->name('json.category');
        Route::get('category/trashed', 'JsonController@trashedCategory')->name('json.trashed.category');
    });
});