<?php


Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@getAll')->name('api.all.users');
        Route::get('/{user}', 'UserController@getById')->name('api.getby.id');
        Route::post('/create', 'UserController@addUser')->name('api.add.user');
        Route::patch('{id}/update', 'UserController@update')->name('api.update.user');
        Route::delete('{id}/delete', 'UserController@delete')->name('api.delete.user');
    });
});