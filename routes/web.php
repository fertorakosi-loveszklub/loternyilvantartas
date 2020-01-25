<?php

Route::get('/', 'HomeController@index');
Route::resource('/calibers', 'CaliberController');
Route::resource('/ammo', 'AmmoTransactionController');

Route::get('/shooting', 'ShootingController@index')->name('shooting.index');
Route::get('/shooting/create', 'ShootingController@create')->name('shooting.create');
Route::post('/shooting/store', 'ShootingController@store')->name('shooting.store');
Route::post('/shooting/giveout', 'ShootingController@giveout')->name('shooting.giveout');
Route::post('/shooting/takeback', 'ShootingController@takeback')->name('shooting.takeback');
Route::post('/shooting/finish', 'ShootingController@finish')->name('shooting.finish');
