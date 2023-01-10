<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountManagerController;
use App\Http\Controllers\CheckingInfoServiceController;
use App\Http\Controllers\UtilController;

Route::group(['prefix' => 'util', 'as'=>'util.'], function($route){
    $route->post('/search-user', [UtilController::class, 'searchUser'])->name('searchUser');

});
