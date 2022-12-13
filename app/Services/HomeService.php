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
use App\Services\UtilitiesService;

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
    protected $utilitiesService;
    public function __construct(
        HomeRepository $homeRepo,
        ClassifyService $classifyService,
        CityService $cityService,
        PostService $postService,
        UserRepository $userRepo,
        UtilitiesService $utilitiesService
    ) {
        $this->homeRepo = $homeRepo;
        $this->classifyService = $classifyService;
        $this->cityService = $cityService;
        $this->postService = $postService;
        $this->userRepo = $userRepo;
        $this->utilitiesService = $utilitiesService;
    }

    public function loadAllForHomePage()
    {
        $dataReturn = [];
        $dataReturn['classifies'] = $this->classifyService->takeAllClassify();
        $dataReturn['cities'] = $this->cityService->takeAllCity();
        $dataReturn['exchange'] = $this->utilitiesService->takeAllCurrencyExchangeForMain();
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
            $postData['images'] = [];
            foreach ($post->post_attachments as $attachment) {
                array_push($postData['images'], asset($attachment->attachment_path));
                // if ($attachment->attachment_type == POST_DESCRIPTION_PHOTO) {
                //     $imgPath = asset($attachment->attachment_path);
                //     break;
                // }
            }
            // $postData['images'] = $imgPath;

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
            if ($params['userId'] != 0 && $this->userRepo->isUser($params['userId'])) {
                $postData['isUser'] = true;
                $postData['liked'] = $post->checkPostLiked($params['userId'], $post->id);
            } else {
                $postData['isUser'] = false;
            }

            $postData['avatar'] = $post->user->user_avatar ? asset($post->user->user_avatar) : asset('storage/avatar-sample/ava1.jpg');

            $postData['accessTimes'] = $post->access_times ?? 0;
            $postData['rating'] = '';
            for ($i = 1; $i < 6; $i++) {
                if ($i <= $post->rating_score) {
                    $postData['rating'] = $postData['rating'] . '<span class="fa fa-star rating-star-checked"></span>';
                } else {
                    $postData['rating'] = $postData['rating'] . '<span class="fa fa-star"></span>';
                }
            }
            $postData['postLink'] = route('post.mainPost',['postId' => $post->id]);
            $postData['ownerName']  = $post->user->name;
            $postData['ownerId'] = $post->user->id;
            $postData['times'] = $postTimes;

            $postData['title'] =  $post->title;
            $postData['description'] = nl2br($post->description);

            array_push($response, $postData);
        }

        return $response;
    }
}
