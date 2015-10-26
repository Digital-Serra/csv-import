<?php
// Site Routes
Route::get('/',['as'=>'home.index','uses'=>'HomeController@index']);

// Cancel news subscription
Route::get('/unsubscribe/{token}',['as'=>'dashboard.cancelSubscription','uses'=>'Dashboard\NewsController@cancelSubscription']);