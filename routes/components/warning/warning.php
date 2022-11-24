<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'warning', 'as'=>'warning.'], function($route){
    $route->get('/account-require', function (){return view('warnings.needAccountForAccess');})->name('accountRequire');
});
