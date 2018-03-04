<?php

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@authenticate');

Route::get('/logout', 'AuthController@logout');

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@index');
