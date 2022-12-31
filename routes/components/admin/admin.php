<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountManagerController;
use App\Http\Controllers\CheckingInfoServiceController;
use App\Http\Controllers\PostCommentController;

Route::group(['prefix' => 'admin', 'as'=>'admin.'], function($route){
    $route->group(['prefix'=>'account', 'as'=>'account.'], function($route){
        $route->get('/',[ AccountManagerController::class, 'index'])->name('index');
        $route->post('/change-action',[ AccountManagerController::class, 'changeAction'])->name('changeAction');
        $route->any('/create-account/{accountType}',[AccountManagerController::class, 'createAccount'])->name('createAccount');
    });

    $route->group(['prefix'=>'checking-info', 'as'=>'checkingInfo.'], function($route){
        $route->get('/', [CheckingInfoServiceController::class , 'adminIndex'])->name('index');
        $route->post('/carticket-update-result',[CheckingInfoServiceController::class , 'carTicketResultUpdate'])->name('carTicketResultUpdate');
        $route->post('/entryban-update-result',[CheckingInfoServiceController::class , 'entryBanResultUpdate'])->name('entryBanResultUpdate');
        $route->post('/taxdebt-update-result',[CheckingInfoServiceController::class , 'taxDebtResultUpdate'])->name('taxDebtResultUpdate');
        $route->post('/adminis-update-result',[CheckingInfoServiceController::class , 'adminisResultUpdate'])->name('adminisResultUpdate');
        $route->post('/remove-requirement',[CheckingInfoServiceController::class , 'removeRequirement'])->name('removeRequirement');
        $route->post('/remove-result',[CheckingInfoServiceController::class , 'removeResult'])->name('removeResult');
    });

    $route->group(['prefix'=>'comment-manager', 'as'=>'commentManager.'], function($route){
        $route->get('/', [PostCommentController::class , 'adminIndex'])->name('index');
        $route->get('/comment-interact/{commentId}/{status}', [PostCommentController::class , 'adminCommentInteract'])->name('adminCommentInteract');

    });

});
