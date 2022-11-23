<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostsController;
use App\Http\Controllers\InteractionController;


Route::group(['prefix' => 'post', 'as'=>'post.'], function($route){
    $route->any('/', [ PostsController::class, 'index'])->name('index');
    $route->post('/free-upload/{classify}/{classifyType}', [ PostsController::class, 'freeUpload'])->name('freeUpload');
    $route->post('/choose-topic', [ PostsController::class, 'checkTypeInsideClassify'])->name('chooseTopic');
    $route->post('delete-post',[ PostsController::class, 'deletePost'] )->name('deletePost');
    $route->group(['prefix'=>'post-interact', 'as'=>'postInteract.'], function($route){
        $route->post('like', [InteractionController::class, 'likePost'])->name('like');
        $route->post('unlike', [InteractionController::class, 'unlikePost'])->name('unlike');
        $route->any('posts-liked/{userId}', [InteractionController::class, 'postLiked'])->name('postLiked');
    });

    $route->group(['prefix' => 'mypost', 'as'=>'myPost.'], function ($route){
        $route->get('/{userId}',[PostsController::class, 'myPostIndex'])->name('index');
        $route->post('/loading',[PostsController::class, 'myPostLoadMore'])->name('loading');

    });
});
