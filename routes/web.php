<?php

Route::get('/', 'HomeController@index');
Route::resource('/calibers', 'CaliberController');
Route::resource('/ammo', 'AmmoTransactionController');
