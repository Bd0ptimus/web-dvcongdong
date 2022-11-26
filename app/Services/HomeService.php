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
use App\Services\PostService;


//repo
use App\Repositories\HomeRepository;
use App\Repositories\UserRepository;



use Exception;

class HomeService
{
    protected $homeRepo;
    protected $classifyService;
    protected $cityService;
    protected $postService;
    protected $userRepo;

    public function __construct(
        HomeRepository $homeRepo,
        ClassifyService $classifyService,
        CityService $cityService,
        PostService $postService,
        UserRepository $userRepo
    ) {
        $this->homeRepo = $homeRepo;
        $this->classifyService = $classifyService;
        $this->cityService = $cityService;
        $this->postService = $postService;
        $this->userRepo = $userRepo;
    }

    public function loadAllForHomePage()
    {
        $dataReturn = [];
        $dataReturn['classifies'] = $this->classifyService->takeAllClassify();
        $dataReturn['cities'] = $this->cityService->takeAllCity();
        // dd( $dataReturn);
        return $dataReturn;
    }

    public function newFeedLoading($numberStep, $params)
    {
        $posts = $this->postService->loadForNewFeed($numberStep, $params);
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
                $postTimes = date('d/m/Y', strtotime($createdAt));
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

            $postData['times'] = $postTimes;

            $postData['title']=  $post->title;
            $postData['description'] = $post->description;

            array_push($response, $postData);
        }

        return $response;
    }
}
