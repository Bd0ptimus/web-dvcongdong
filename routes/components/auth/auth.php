<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\InteractionController;


Route::group(['prefix' => 'auth', 'as'=>'auth.'], function($route){
    $route->any('/login', [ LoginController::class, 'index'])->name('login');
    $route->any('/register', [ RegisterController::class, 'index'])->name('register');

});
