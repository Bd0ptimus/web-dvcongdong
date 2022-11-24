<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CheckingInfoServiceController;


Route::group(['prefix' => 'check', 'as'=>'check.'], function($route){
    $route->post('/add-new', [ CheckingInfoServiceController::class, 'addNewRequest'])->name('addNew');
});
