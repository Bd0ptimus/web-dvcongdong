<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\InteractionController;


Route::group(['prefix' => 'auth', 'as'=>'auth.'], function($route){
    $route->any('/login', [ LoginController::class, 'index'])->name('login');
    $route->any('/register', [ RegisterController::class, 'index'])->name('register');
    $route->group(['prefix'=>'google', 'as' => 'google.'], function($route){
        $route->get('/login', [LoginController::class, 'googleLogin'])->name('googleLogin');
        $route->get('/login-callback', [LoginController::class, 'googleLoginedCallback'])->name('googleLoginCallback');

    });
    $route->group(['prefix'=>'facebook', 'as' => 'facebook.'], function($route){
        $route->get('/login', [LoginController::class, 'facebookLogin'])->name('facebookLogin');
        $route->get('/login-callback', [LoginController::class, 'facebookLoginCallback'])->name('facebookLoginCallback');

    });

    $route->group(['prefix'=>'vk', 'as' => 'vk.'], function($route){
        $route->get('/login', [LoginController::class, 'vkLogin'])->name('vkLogin');
        $route->get('/login-callback', [LoginController::class, 'vkLoginCallback'])->name('vkLoginCallback');

    });

    $route->group(['prefix'=>'zalo', 'as' => 'zalo.'], function($route){
        $route->get('/login', [LoginController::class, 'zaloLogin'])->name('zaloLogin');
        $route->get('/login-callback', [LoginController::class, 'zaloLoginedCallback'])->name('zaloLoginCallback');

    });


});
