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
use App\Repositories\UserRepository;


use Exception;
class SearchService
{

    protected $postService;
    protected $userRepo;
    public function __construct(PostService $postService,
    UserRepository $userRepo){
        $this->postService = $postService;
        $this->userRepo = $userRepo;
    }


    public function searchNewFeedLoading($filter,$numberStep){
        $posts= $this->postService->searchPosts($filter,$numberStep);
        $response = [];
        foreach ($posts as $post) {
            //load img
            $imgPath = asset('storage/template/post/none-pic-logo.jpg');
            $postData['images']=[];

            foreach ($post->post_attachments as $attachment) {
                array_push($postData['images'] ,asset($attachment->attachment_path));
            }

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

            $postData['avatar'] = $post->user->user_avatar?asset($post->user->user_avatar):asset('storage/avatar-sample/ava1.jpg');

            $postData['accessTimes'] = $post->access_times??0;
            $postData['rating']='';
            for($i=1; $i<6;$i++){
                if($i<= $post->rating_score){
                    $postData['rating'] =$postData['rating'].'<span class="fa fa-star rating-star-checked"></span>';
                }else{
                    $postData['rating'] =$postData['rating'].'<span class="fa fa-star"></span>';
                }
            }
            $postData['postLink'] = route('post.mainPost',['postId' => $post->id]);

            $postData['ownerName']  = $post->user->name;
            $postData['ownerId'] = $post->user->id;

            $postData['times'] = $postTimes;

            $postData['title']=  $post->title;
            $postData['description'] = $post->description;

            array_push($response, $postData);
        }

        return $response;
    }

    public function searchUser($request){
        $users =$this->userRepo->searchUser($request->searchVal);
        $data = '';
        // LOG::debug('user : ' . print_r($users, true));
        foreach ($users as $user){
            $userAvatar = asset($user->user_avatar);
            $onclick = "chooseUser({$user->id},'{$userAvatar}', '{$user->name}', '{$user->email}','{$user->phone_number}')";
            $data = $data.'<div class ="searchUserResultLine d-flex justify-content-start"  onclick="'.$onclick.'">
                            <div style="height:100%; width:15%;" class="vertical-container">
                                <img src = "'.asset($user->user_avatar).'">
                            </div>
                            <div style="height:100%; width:25%; overflow:hidden; padding:0px 3px;" class="vertical-container">
                                <span  class="form-text vertical-element-middle-align">'.$user->name.'</span>

                            </div>
                            <div style="height:100%; width:40%; overflow:hidden; padding:0px 3px;" class="vertical-container">
                                <span style="" class="form-text vertical-element-middle-align">'.$user->email.'</span>

                            </div>
                            <div style="height:100%; width:20%; overflow:hidden; padding:0px 3px;" class="vertical-container">
                                <span class="form-text vertical-element-middle-align">'.$user->phone_number.'</span>

                            </div>
                        </div>';
        }
        return $data;
    }
}
