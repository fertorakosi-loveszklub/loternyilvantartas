<?php

Route::get('/', 'HomeController@index');
Route::resource('/calibers', 'CaliberController');
