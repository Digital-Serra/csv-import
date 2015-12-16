<?php
//DashBoard Routes
Route::group(['middleware' => 'auth','namespace'=>'Dashboard'], function () {
    Route::get('/dashboard',['as'=>'dashboard.index','uses'=>'DashController@index']);

    // Import
    Route::get('/dashboard/import',['as'=>'dashboard.getImport','uses'=>'NewsController@getImport']);
    Route::post('/dashboard/import',['as'=>'dashboard.postImport','uses'=>'NewsController@postImport']);

    // Export
    Route::get('/dashboard/export',['as'=>'dashboard.getExport','uses'=>'NewsController@getExport']);

    // Show
    Route::get('/dashboard/emails',['as'=>'dashboard.showEmails','uses'=>'NewsController@showEmails']);


    // Test email templates
    Route::get('/dashboard/templates/{name}',function($name){
        return view('emails.templates.'.$name)
            ->with('name','Digital Serra')
            ->with('email','contato@digitalserra.com.br')
            ->with('title','Tìtulo')
            ->with('token',bin2hex(random_bytes(30)));
    });
});