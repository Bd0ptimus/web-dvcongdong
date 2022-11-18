<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Admin;
//model

//services
use App\Services\CityService;
use App\Services\ClassifyService;
use App\Services\RealEstateService;
use App\Services\AttachmentService;
use App\Services\JobService;
use App\Services\CarTradeService;
use App\Services\GarmentService;
use App\Services\MomBabyService;
use App\Services\RestaurantService;
use App\Services\ClassifyAdsService;
use App\Services\WebServicesService;




//repo
use App\Repositories\PostRepository;


use Exception;

class PostService
{
    protected $postRepo;
    protected $classifyService;
    protected $cityService;
    protected $realEstateService;
    protected $attachmentService;
    protected $jobService;
    protected $carTradeService;
    protected $garmentService;
    protected $momBabyService;
    protected $restaurantService;
    protected $classifyAdsService;
    protected $webServicesService;

    public function __construct(
        PostRepository $postRepo,
        ClassifyService $classifyService,
        CityService $cityService,
        RealEstateService $realEstateService,
        AttachmentService $attachmentService,
        JobService $jobService,
        CarTradeService $carTradeService,
        GarmentService $garmentService,
        MomBabyService $momBabyService,
        RestaurantService $restaurantService,
        ClassifyAdsService $classifyAdsService,
        WebServicesService $webServicesService
    ) {
        $this->postRepo = $postRepo;
        $this->classifyService = $classifyService;
        $this->cityService = $cityService;
        $this->realEstateService = $realEstateService;
        $this->attachmentService = $attachmentService;
        $this->jobService=$jobService;
        $this->carTradeService = $carTradeService;
        $this->garmentService = $garmentService;
        $this->momBabyService = $momBabyService;
        $this->restaurantService = $restaurantService;
        $this->classifyAdsService= $classifyAdsService;
        $this->webServicesService = $webServicesService;
    }

    public function takeAllForCreatePost($classifyChoosen, $classifyTypeChoosen = null)
    {
        // dd($classifyChoosen. ' - '. $classifyTypeChoosen);
        $header = "ĐĂNG TIN ";
        // dd($classifyTypeChoosen);
        if ($classifyTypeChoosen != null && $classifyTypeChoosen != 0) {
            $classifyData = $this->classifyService->takeClassifyWithTypes($classifyChoosen, $classifyTypeChoosen);
            // dd($classifyData);
            $classifyTypeData = $classifyData->classifyTypes[0];
            $title = $classifyTypeData->type_name;
            $haveTitle = true;
            $data['title'] = $title;
            // dd($classifyData->classifyTypes[0]);
        } else {
            $classifyData = $this->classifyService->takeClassifyById($classifyChoosen);
            $haveTitle = false;
        }
        $header = $header . $classifyData->classify_name_upper;
        $data['header'] = $header;
        $data['haveTitle'] = $haveTitle;
        $data['cities'] = $this->cityService->takeAllCity();
        $data['classify'] = $classifyChoosen;
        $data['classifyType'] = $classifyTypeChoosen;

        return $data;
    }


    public function takeAllForChooseTopic()
    {
        $data['classifies'] = $this->classifyService->takeAllClassify();
        $data['header'] = "ĐĂNG TIN ";
        foreach ($data['classifies'] as $key => $classify) {
            if ($key == 0) {
                $data['header'] =  $data['header'] . $classify->classify_name_upper;
            } else if ($key <= 3 && $key > 0) {
                $data['header'] = $data['header'] . ', ' . $classify->classify_name_upper;
            } else {
                $data['header'] =  $data['header'] . ' ...';
                break;
            }
        }
        return $data;
    }

    public function processUploadNewPost($request, $classify, $classifyType)
    {
        DB::beginTransaction();
        try {
            switch ($classify) {
                case (REAL_ESTATE):
                    $realEstate = $this->realEstateService->uploadPostRealEstate($request);
                    $post= $this->postRepo->createNewPostBaseOnClassify($realEstate, $request, REAL_ESTATE);
                    // dd($realEstate);
                    break;
                case (SERVICE):
                    $serivce = $this->webServicesService->uploadPostService($request,$classifyType);
                    $post= $this->postRepo->createNewPostBaseOnClassify($serivce, $request, SERVICE);
                    break;
                case (JOB):
                    $job = $this->jobService->uploadPostJob($request);
                    $post= $this->postRepo->createNewPostBaseOnClassify($job, $request, JOB);
                    break;
                case (CAR_TRADE):
                    $carTrade = $this->carTradeService->uploadPostCarTrade($request);
                    $post= $this->postRepo->createNewPostBaseOnClassify($carTrade, $request, CAR_TRADE);
                    break;
                case (GARMENT):
                    $garment = $this->garmentService->uploadPostGarment($request);
                    $post= $this->postRepo->createNewPostBaseOnClassify($garment, $request, GARMENT);
                    break;
                case (MOM_BABY):
                    $mombaby = $this->momBabyService->uploadPostMomBaby($request);
                    $post= $this->postRepo->createNewPostBaseOnClassify($mombaby, $request, MOM_BABY);
                    break;
                case (RESTAURANT):
                    $retaurant =$this->restaurantService->uploadPostRestaurant($request);
                    $post= $this->postRepo->createNewPostBaseOnClassify($retaurant, $request, RESTAURANT);
                    break;
                case (AD):
                    $ads =$this->classifyAdsService->uploadPostAds($request);
                    $post= $this->postRepo->createNewPostBaseOnClassify($ads, $request, AD);
                    break;
            }
            // dd($realEstate);
             $this->attachmentService->addNewPostAttachments($post->id,$request);
            // dd($request->files);
            DB::commit();
            $data['error'] = 0;
            $data['confirmText'] = '<p style="width:auto;">Tin được đăng từ ngày '.date('d/m/Y', strtotime($post->exist_from)).' đến ngày '.date('d/m/Y', strtotime($post->exist_to)).'</p>
                                    <p style="width:auto;">Bởi người dùng :'.$post->user->name.' </p>
                                    <p style="width:auto;">Số điện thoại liên hệ :'.$post->contact_phone_number.' </p>
                                    <p style="width:auto;">Email liên hệ :'.$post->user->email.' </p>
                                    <p style="width:auto;">Với tiêu đề : '.$post->title.'</p>
                                    <p style="width:auto;">Với mô tả: '.$post->description.'</p>';
            return $data;
        } catch (\Exception $e) {
            Log::debug('processUploadNewPost : ' . $e);
            DB::rollBack();
            $data['error'] = 1;
            return $data;
        }
    }

    public function loadForNewFeed($numPage,$params=[]){
        return $this->postRepo->loadPostsForNewFeed($numPage, $params);
    }

    public function searchPosts($filterData, $numberStep=0){
        return $this->postRepo->findPostsWithCondition($filterData, $numberStep);
    }

    public function likePost($postId, $userId){
        $respone['error'] = 1;
        // Log::debug('check condition : '. Admin::user()!==null);
        Log::debug('check user : '. Admin::user()->isRole(ROLE_USER));

        Log::debug('check condition : '. Admin::user()->isRole(ROLE_USER));
        Log::debug('check userId input : '.$userId);

        Log::debug('check use id : '. Admin::user()->id);

        if(Admin::user()!==null&&Admin::user()->isRole(ROLE_USER)&&$userId == Admin::user()->id){
            Log::debug('in post service like post');
            $this->postRepo->addInteractPost($postId, $userId, LIKE);
            $respone['error'] = 0;
        }
        return $respone;
    }
}
