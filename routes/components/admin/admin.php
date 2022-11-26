<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountManagerController;
use App\Http\Controllers\CheckingInfoServiceController;



Route::group(['prefix' => 'admin', 'as'=>'admin.'], function($route){
    $route->group(['prefix'=>'account', 'as'=>'account.'], function($route){
        $route->get('/',[ AccountManagerController::class, 'index'])->name('index');
        $route->post('/change-action',[ AccountManagerController::class, 'changeAction'])->name('changeAction');
        $route->any('/create-account/{accountType}',[AccountManagerController::class, 'createAccount'])->name('createAccount');
    });

    $route->group(['prefix'=>'checking-info', 'as'=>'checkingInfo.'], function($route){
        $route->get('/', [CheckingInfoServiceController::class , 'adminIndex'])->name('index');
        $route->post('/carticket-update-result',[CheckingInfoServiceController::class , 'carTicketResultUpdate'])->name('carTicketResultUpdate');
    });

});
