<?php


Route::group(['prefix' => 'v1/users'], function () {
    Route::get('/', 'UserController@getAll')->name('api.all.users');
    Route::get('/{user}', 'UserController@getById')->name('api.getby.id');
    Route::post('/create', 'UserController@addUser')->name('api.add.user');
    Route::post('{user}/update', 'UserController@edit')->name('api.edit.user');
    Route::delete('{user}/delete', 'UserController@delete')->name('api.delete.user');
});