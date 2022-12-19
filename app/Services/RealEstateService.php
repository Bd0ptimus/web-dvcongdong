<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;

//model

//services
use App\Services\CityService;
use App\Services\ClassifyService;

//repo
use App\Repositories\RealEstateRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;




use Exception;
class RealEstateService
{
    protected $realEstateRepo;
    protected $postRepo;
    protected $userRepo;
    public function __construct(RealEstateRepository $realEstateRepo,
    PostRepository $postRepo,
    UserRepository $userRepo){
        $this->realEstateRepo = $realEstateRepo;
        $this->postRepo = $postRepo;
        $this->userRepo = $userRepo;
    }


    public function uploadPostRealEstate($request){
        return $this->realEstateRepo->realEstatePostCreate($request);
    }

    public function findPostRealEstateById($id){
        return $this->realEstateRepo->findById($id);
    }


    public function loadMoreRealEstate($numPage,$params){

        $posts = $this->postRepo->findPostsWithCondition($params,$numPage);
        $response = [];
        foreach ($posts as $post) {
            //load img
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

            if($params['userId'] != 0 && $this->userRepo->isUser($params['userId'])){
                $postData['isUser'] = true;
                $postData['liked'] = $post->checkPostLiked($params['userId'], $post->id);
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
            $postData['ownerName']  = $post->user->name;
            $postData['times'] = $postTimes;

            $postData['title']=  $post->title;
            $postData['description'] = $post->description;

            array_push($response, $postData);
        }


        return $response;
    }
}
