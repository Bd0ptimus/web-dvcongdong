<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::group(['prefix' => 'home', 'as'=>'home.'], function($route){
    Route::post('/home-newfeed-loading', [ HomeController::class, 'newFeedLoading'])->name('homeNewFeedLoading');
    Route::post('/home-search', [ HomeController::class, 'searchAction'])->name('homeSearching');
});
