<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserAccountDetailController;

Route::group(['prefix' => 'user', 'as'=>'user.'], function($route){
    $route->get('/{userId}',[UserAccountDetailController::class, 'index'])->name('index');
    $route->group(['prefix'=>'setting', 'as'=>'setting.'], function($route){
        $route->post('change-avatar', [UserAccountDetailController::class, 'changeAvatar'])->name('changeAvatar');
    });
});
