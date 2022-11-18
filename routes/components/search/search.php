<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SearchingController;

Route::group(['prefix' => 'search', 'as'=>'search.'], function($route){
    Route::get('/', [ SearchingController::class, 'index'])->name('index');
    Route::post('/home-search', [ SearchingController::class, 'searchAction'])->name('homeSearch');
    Route::post('/search-result-loading', [ SearchingController::class, 'searchingLoading'])->name('searchResultLoading');
});
