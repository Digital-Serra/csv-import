<?php
//DashBoard Routes
Route::group(['middleware' => 'auth','namespace'=>'Dashboard'], function () {
    Route::get('/dashboard',['as'=>'dashboard.index','uses'=>'DashController@index']);
    Route::get('/dashboard',['as'=>'dashboard.index','uses'=>'DashController@index']);

    // Import
    Route::get('/dashboard/import',['as'=>'dashboard.getImport','uses'=>'NewsController@getImport']);
    Route::post('/dashboard/import',['as'=>'dashboard.postImport','uses'=>'NewsController@postImport']);

    // Import
    Route::get('/dashboard/emails',['as'=>'dashboard.showEmails','uses'=>'NewsController@showEmails']);


    // Test email templates
    Route::get('/dashboard/emails/template/{name}',function($name){
        return view('emails.templates.'.$name);
    });



});