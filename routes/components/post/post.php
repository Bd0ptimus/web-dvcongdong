<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostsController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\RealEstateController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\CarTradeController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\ClassifyAdsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PostCommentController;





Route::group(['prefix' => 'post', 'as'=>'post.'], function($route){
    $route->any('/', [ PostsController::class, 'index'])->name('index');
    $route->post('/free-upload/{classify}/{classifyType}', [ PostsController::class, 'freeUpload'])->name('freeUpload');
    $route->post('/choose-topic', [ PostsController::class, 'checkTypeInsideClassify'])->name('chooseTopic');
    $route->post('delete-post',[ PostsController::class, 'deletePost'] )->name('deletePost');
    $route->any('edit-post/{postId}',[ PostsController::class, 'editPost'] )->name('editPost');

    $route->group(['prefix'=>'post-category', 'as'=>'postCategory.'], function($route){
        $route->group(['prefix'=>'real-estate', 'as'=>'realEstate.'], function($route){
            $route->get('/',[RealEstateController::class, 'index'])->name('index');
            $route->post('/load-more',[RealEstateController::class, 'loadMoreRealEstate'])->name('loadMore');
        });

        $route->group(['prefix'=>'job', 'as'=>'job.'], function($route){
            $route->get('/',[JobsController::class, 'index'])->name('index');
            $route->post('/load-more',[JobsController::class, 'loadMoreJob'])->name('loadMore');
        });

        $route->group(['prefix'=>'car-trading', 'as'=>'carTrade.'], function($route){
            $route->get('/',[CarTradeController::class, 'index'])->name('index');
            $route->post('/load-more',[CarTradeController::class, 'loadMoreCarTrade'])->name('loadMore');
        });

        $route->group(['prefix'=>'restaurant', 'as'=>'restaurant.'], function($route){
            $route->get('/',[RestaurantsController::class, 'index'])->name('index');
            $route->post('/load-more',[RestaurantsController::class, 'loadMoreRestaurant'])->name('loadMore');
        });

        $route->group(['prefix'=>'ad', 'as'=>'ad.'], function($route){
            $route->get('/',[ClassifyAdsController::class, 'index'])->name('index');
            $route->post('/load-more',[ClassifyAdsController::class, 'loadMoreAd'])->name('loadMore');
        });

        $route->group(['prefix'=>'service', 'as'=>'service.'], function($route){
            $route->get('/{classifyId}',[ServiceController::class, 'index'])->name('index');
            $route->post('/load-more/{classifyId}',[ServiceController::class, 'loadMoreService'])->name('loadMore');

        });
    });


    $route->group(['prefix'=>'post-interact', 'as'=>'postInteract.'], function($route){
        $route->post('like', [InteractionController::class, 'likePost'])->name('like');
        $route->post('unlike', [InteractionController::class, 'unlikePost'])->name('unlike');
        $route->any('posts-liked/{userId}', [InteractionController::class, 'postLiked'])->name('postLiked');
    });

    $route->group(['prefix' => 'mypost', 'as'=>'myPost.'], function ($route){
        $route->get('/{userId}',[PostsController::class, 'myPostIndex'])->name('index');
        $route->post('/loading',[PostsController::class, 'myPostLoadMore'])->name('loading');
    });

    $route->get('/open/{postId}',[PostsController::class, 'mainPost'])->name('mainPost');
    $route->get('/edit-confirm/{postId}/{confirm}',[PostsController::class, 'editConfirm'])->name('editConfirm');

    $route->group(['prefix' => 'comment', 'as'=>'comment.'], function ($route){
        $route->post('/upload-comment',[PostCommentController::class, 'addNewComment'])->name('uploadComment');
        $route->get('/load-comment',[PostCommentController::class, 'loadComment'])->name('loadComment');
        $route->get('/load-comment-test/{postId}/{step}',[PostCommentController::class, 'loadCommentTest'])->name('loadCommentTest');

    });

});
