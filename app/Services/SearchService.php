<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;

//model

//services
use App\Services\PostService;
use App\Services\ClassifyService;

//repo
use App\Repositories\JobRepository;


use Exception;
class SearchService
{

    protected $postService;
    public function __construct(PostService $postService){
        $this->postService = $postService;
    }


    public function searchNewFeedLoading($filter,$numberStep){
        $posts= $this->postService->searchPosts($filter,$numberStep);
        $response = [];
        foreach ($posts as $post) {
            //load img
            $imgPath = asset('storage/template/post/none-pic-logo.jpg');
            foreach ($post->post_attachments as $attachment) {
                if ($attachment->attachment_type == POST_DESCRIPTION_PHOTO) {
                    $imgPath = asset($attachment->attachment_path);
                    break;
                }
            }
            $postData['image'] = $imgPath;

            //address
            $postAddress = 'Toàn Nga';
            if (isset($post->city)) {
                $postAddress = $post->city->city;
            }

            $postData['address'] = $postAddress;

            //classify
            $postClassify = CLASSIFY_SLUG[$post->posts_classify_type];
            if ($post->posts_classify_type == SERVICE_SLUG) {
                $postClassify = $postClassify . ', ' . SERVICE_TYPE_SLUG[$post->posts_classify->services_type_type];
            }
            $postData['classify'] = $postClassify;

            //Times
            $now = \Carbon\Carbon::now();
            $createdAt = \Carbon\Carbon::parse($post->created_at);
            $postTimes = $createdAt->diffInDays($now);
            if ($postTimes == 0) {
                $postTimes = $createdAt->diffInHours($now);
                if ($postTimes == 0) {
                    $postTimes = 'gần đây';
                } else {
                    $postTimes = $postTimes . ' giờ trước';
                }
            } elseif ($postTimes > 30) {
                $postTimes = date('m/d/Y', strtotime($createdAt));
            } else {
                $postTimes = $postTimes . ' ngày trước';
            }

            $postData['id'] = $post->id;
            if($filter['userId'] != 0){
                $postData['isUser'] = true;
                $postData['liked'] = $post->checkPostLiked($filter['userId'], $post->id);
            }else{
                $postData['isUser'] = false;
            }

            $postData['times'] = $postTimes;

            $postData['title']=  $post->title;
            $postData['description'] = $post->description;

            array_push($response, $postData);
        }

        return $response;
    }
}
