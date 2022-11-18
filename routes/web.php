<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require_once 'components/post/post.php';
require_once 'components/home/home.php';
require_once 'components/search/search.php';



Route::any('/', [ HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// Route::get('/', function(){return view('main'); })->name('main');

// Route::get('/', function () {
//     return view('main');
// });

Route::get('/header', function () {
    return view('layouts.header');
});

Route::get('/test', function () {
    return view('search.index');
});

Auth::routes();

