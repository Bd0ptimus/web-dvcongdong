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
use App\Repositories\UserRepository;
use App\Repositories\PostAttachmentRepository;
use App\Repositories\PostCommentRepository;




//repo
use App\Repositories\PostRepository;


//Models
use App\Models\post;

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
    protected $userRepo;
    protected $postAttachmentRepo;
    protected $postCommentRepo;

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
        WebServicesService $webServicesService,
        UserRepository $userRepo,
        PostAttachmentRepository $postAttachmentRepo,
        PostCommentRepository $postCommentRepo
    ) {
        $this->postRepo = $postRepo;
        $this->classifyService = $classifyService;
        $this->cityService = $cityService;
        $this->realEstateService = $realEstateService;
        $this->attachmentService = $attachmentService;
        $this->jobService = $jobService;
        $this->carTradeService = $carTradeService;
        $this->garmentService = $garmentService;
        $this->momBabyService = $momBabyService;
        $this->restaurantService = $restaurantService;
        $this->classifyAdsService = $classifyAdsService;
        $this->webServicesService = $webServicesService;
        $this->userRepo = $userRepo;
        $this->postAttachmentRepo = $postAttachmentRepo;
        $this->postCommentRepo = $postCommentRepo;
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
                    $post = $this->postRepo->createNewPostBaseOnClassify($realEstate, $request, REAL_ESTATE);
                    // dd($realEstate);
                    break;
                case (SERVICE):
                    $serivce = $this->webServicesService->uploadPostService($request, $classifyType);
                    $post = $this->postRepo->createNewPostBaseOnClassify($serivce, $request, SERVICE);
                    break;
                case (JOB):
                    $job = $this->jobService->uploadPostJob($request);
                    $post = $this->postRepo->createNewPostBaseOnClassify($job, $request, JOB);
                    break;
                case (CAR_TRADE):
                    $carTrade = $this->carTradeService->uploadPostCarTrade($request);
                    $post = $this->postRepo->createNewPostBaseOnClassify($carTrade, $request, CAR_TRADE);
                    break;
                case (GARMENT):
                    $garment = $this->garmentService->uploadPostGarment($request);
                    $post = $this->postRepo->createNewPostBaseOnClassify($garment, $request, GARMENT);
                    break;
                case (MOM_BABY):
                    $mombaby = $this->momBabyService->uploadPostMomBaby($request);
                    $post = $this->postRepo->createNewPostBaseOnClassify($mombaby, $request, MOM_BABY);
                    break;
                case (RESTAURANT):
                    $retaurant = $this->restaurantService->uploadPostRestaurant($request);
                    $post = $this->postRepo->createNewPostBaseOnClassify($retaurant, $request, RESTAURANT);
                    break;
                case (AD):
                    $ads = $this->classifyAdsService->uploadPostAds($request);
                    $post = $this->postRepo->createNewPostBaseOnClassify($ads, $request, AD);
                    break;
            }
            // dd($realEstate);
            $this->attachmentService->addNewPostAttachments($post->id, $request);
            // dd($request->files);
            DB::commit();
            $data['error'] = 0;
            $data['confirmText'] = '<p style="width:auto; font-weight:700;">Tin được đăng từ ngày ' . date('d/m/Y', strtotime($post->exist_from)) . ' đến ngày ' . date('d/m/Y', strtotime($post->exist_to)) . '</p>
                                    <p style="width:auto; font-weight:700;">Bởi người dùng :</p><p>' . $post->user->name . ' </p>
                                    <p style="width:auto; font-weight:700;">Số điện thoại liên hệ :</p><p>' . $post->contact_phone_number . ' </p>
                                    <p style="width:auto; font-weight:700;">Email liên hệ :</p><p>' . $post->user->email . ' </p>
                                    <p style="width:auto; font-weight:700;">Với tiêu đề : </p><p>' . $post->title . '</p>
                                    <p style="width:auto; font-weight:700;">Với mô tả: </p><p>' . nl2br($post->description) . '</p>';
            return $data;
        } catch (\Exception $e) {
            Log::debug('processUploadNewPost : ' . $e);
            DB::rollBack();
            $data['error'] = 1;
            return $data;
        }
    }

    public function editPost($postId, $request){
        DB::beginTransaction();
        try{
            $this->attachmentService->updatePostAttachments($postId, $request);
            $post = $this->postRepo->updatePost($postId, $request);
            DB::commit();
            $data['error'] = 0;
            $data['confirmText'] = '<p style="width:auto; font-weight:700;">Tin được đăng từ ngày ' . date('d/m/Y', strtotime($post->exist_from)) . ' đến ngày ' . date('d/m/Y', strtotime($post->exist_to)) . '</p>
                                    <p style="width:auto; font-weight:700;">Bởi người dùng :</p><p>' . $post->user->name . ' </p>
                                    <p style="width:auto; font-weight:700;">Số điện thoại liên hệ :</p><p>' . $post->contact_phone_number . ' </p>
                                    <p style="width:auto; font-weight:700;">Email liên hệ :</p><p>' . $post->user->email . ' </p>
                                    <p style="width:auto; font-weight:700;">Với tiêu đề : </p><p>' . $post->title . '</p>
                                    <p style="width:auto; font-weight:700;">Với mô tả: </p><p>' . nl2br($post->description) . '</p>';
            return $data;
        }catch(Exception $e){
            DB::rollBack();
            Log::debug('processUploadNewPost : ' . $e);
            $data['error'] = 1;
            return $data;
        }

    }

    public function loadForNewFeed($numPage, $params = [])
    {
        return $this->postRepo->loadPostsForNewFeed($numPage, $params);
    }

    public function takeMostAccessPost()
    {
        return $this->postRepo->takeMostAccessPosts();
    }

    public function searchPosts($filterData, $numberStep = 0)
    {
        return $this->postRepo->findPostsWithCondition($filterData, $numberStep);
    }

    public function postLiked($userId)
    {
        return $this->postRepo->allPostLiked($userId);
    }

    public function likePost($postId, $userId)
    {
        $respone['error'] = 1;

        if (Admin::user() !== null && Admin::user()->isRole(ROLE_USER) && $userId == Admin::user()->id) {
            Log::debug('in post service like post');
            DB::beginTransaction();
            try {
                $this->postRepo->addInteractPost($postId, $userId, LIKE);
                $respone['error'] = 0;
                DB::commit();
            } catch (Exception $e) {
                Log::debug('error in likepost : ' . $e);
                DB::rollBack();
                $respone['error'] = 1;
            }
        }
        return $respone;
    }

    public function unlikePost($postId, $userId)
    {
        $response['error'] = 1;
        if (Admin::user() !== null && Admin::user()->isRole(ROLE_USER) && $userId == Admin::user()->id) {

            DB::beginTransaction();
            try {
                $this->postRepo->addInteractPost($postId, $userId, NOT_INTERACT);
                $respone['error'] = 0;
                DB::commit();
            } catch (Exception $e) {
                Log::debug('error in unlikepost : ' . $e);
                DB::rollBack();
                $respone['error'] = 1;
            }
        }
        return $respone;
    }

    public function loadMyPost($numPage, $params)
    {
        return $this->postRepo->loadAllForMyPost($numPage, $params);
    }

    public function loadMoreMyPost($numPage, $params)
    {

        $posts = $this->postRepo->loadAllForMyPost($numPage, $params);

        $response = [];
        foreach ($posts as $post) {
            //load img
            $postData['images'] = [];
            foreach ($post->post_attachments as $attachment) {
                array_push($postData['images'], asset($attachment->attachment_path));
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

            if(Admin::user() !== null){
                $postData['isUser'] = true;
                Log::debug('in user');
                $postData['liked'] = $post->checkPostLiked(Admin::user()->id, $post->id);
                if(Admin::user() !== null && Admin::user()->id == $params['userId']){
                    $postData['isOwner'] = true;
                }else{
                    $postData['isOwner'] = false;
                }

            }else{
                Log::debug('in not user');

                $postData['isUser'] = false;
                $postData['isOwner'] = false;
            }

            // if ($params['userId'] != 0 && $this->userRepo->isUser($params['userId'])) {
            //     $postData['isUser'] = true;
            //     $postData['liked'] = $post->checkPostLiked($params['userId'], $post->id);
            //     Log::debug('in user');
            //     if(Admin::user() !== null && Admin::user()->id == $params['userId']){
            //         $postData['isOwner'] = true;
            //     }else{
            //         $postData['isOwner'] = false;
            //     }
            // } else {
            //     Log::debug('in not user');

            //     $postData['isUser'] = false;
            //     $postData['isOwner'] = false;
            // }

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
            $postData['postLink'] = route('post.mainPost', ['postId' => $post->id]);
            $postData['postEditUrl'] = route('post.editPost',['postId'=>$post->id]);
            $postData['ownerName']  = $post->user->name;
            $postData['ownerId'] = $post->user->id;

            $postData['times'] = $postTimes;

            $postData['title'] =  $post->title;
            $postData['description'] = $post->description;

            array_push($response, $postData);
        }

        return $response;
    }

    public function deletePost($postId)
    {
        $post = post::where('id', $postId)->first();
        if (Admin::user()->id != $post->user_id) {
            $response['permission_allow'] = 0;
        } else {
            $response['permission_allow'] = 1;
            DB::beginTransaction();
            try {
                switch ($post->classify_id) {
                    case (REAL_ESTATE):
                        $postRelation = $this->realEstateService->findPostRealEstateById($post->posts_classify_id);
                        $this->postRepo->deleteAllPostById($postId, $postRelation);
                        break;
                    case (SERVICE):
                        $this->webServicesService->deleteService($post->posts_classify_id);
                        $this->postRepo->deleteById($postId);
                        $this->postAttachmentRepo->deletePostAttachmentsByPostId($postId);
                        $this->postCommentRepo->deleteWithPostId($postId);
                        break;
                    case (JOB):
                        $postRelation = $this->jobService->findPostJobById($post->posts_classify_id);
                        $this->postRepo->deleteAllPostById($postId, $postRelation);
                        break;
                    case (CAR_TRADE):
                        $postRelation = $this->carTradeService->findPostCarTradeById($post->posts_classify_id);
                        $this->postRepo->deleteAllPostById($postId, $postRelation);
                        break;
                    case (GARMENT):
                        $postRelation = $this->garmentService->findPostGarmentById($post->posts_classify_id);
                        $this->postRepo->deleteAllPostById($postId, $postRelation);
                        break;
                    case (MOM_BABY):
                        $postRelation = $this->momBabyService->findPostMombabyById($post->posts_classify_id);
                        $this->postRepo->deleteAllPostById($postId, $postRelation);
                        break;
                    case (RESTAURANT):
                        $postRelation = $this->restaurantService->findPostRestaurantById($post->posts_classify_id);
                        $this->postRepo->deleteAllPostById($postId, $postRelation);
                        break;
                    case (AD):
                        $postRelation = $this->classifyAdsService->findPostAdsById($post->posts_classify_id);
                        $this->postRepo->deleteAllPostById($postId, $postRelation);
                        break;
                }

                // $this->postRepo->deleteAllPostById($postId);
                DB::commit();
                $response['error'] = 0;
            } catch (Exception $e) {
                DB::rollBack();
                Log::debug('error in delete post : ' . $e);
                $response['error'] = 1;
            }
        }
        return $response;
    }

    private function takePostDetailHTML($post,$classify){
        switch ($classify) {
            case (REAL_ESTATE):
                return '<div class="row d-flex justify-content-center mainPost-content-section">
                                                <div class="mainPost-content-title">
                                                    Chi Tiết
                                                </div>
                                                <br>
                                                <div class="row d-flex justify-content-center" style="width:100%; padding:0px;">
                                                    <div class="d-flex justify-content-center detail-sec">
                                                        <div style="width:50%;" class="d-flex justify-content-start ">
                                                            <p style="font-weight:bold;" >Giá (&#8381) :</p>

                                                        </div>
                                                        <div style="width:50%;" class="d-flex justify-content-start ">
                                                            <p class="long-detail-wrap">' . (isset($post->posts_classify->price) ? $post->posts_classify->price : 'Thương lượng') . '</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center detail-sec">
                                                        <div style="width:50%;" class="d-flex justify-content-start">
                                                            <p style="font-weight:bold;" >Diện tích (&#13217) :</p>

                                                        </div>
                                                        <div style="width:50%;" class="d-flex justify-content-start">
                                                            <p class="long-detail-wrap">' . (isset($post->posts_classify->square) ? $post->posts_classify->square : 'Liên hệ') . '</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center detail-sec">
                                                        <div style="width:50%;" class="d-flex justify-content-start">
                                                            <p style="font-weight:bold;" > Địa chỉ nhà đất :</p>

                                                        </div>
                                                        <div style="width:50%;" class="d-flex justify-content-start">
                                                            <p class="long-detail-wrap">' . (isset($post->posts_classify->address) ? $post->posts_classify->address : 'Liên hệ') . '</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center detail-sec">
                                                        <div style="width:50%;" class="d-flex justify-content-start">
                                                            <p style="font-weight:bold;" > Số phòng :</p>
                                                        </div>
                                                        <div style="width:50%;" class="d-flex justify-content-start">
                                                            <p class="long-detail-wrap">' . (isset($post->posts_classify->number_room) ? $post->posts_classify->number_room : 'Liên hệ') . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>';
                break;

            case (SERVICE):
                // switch ($post->posts_classify->classify_type_id) {
                //     case (SERVICE_DOCUMENT):

                //         break;
                //     case (SERVICE_MEDICAL):
                //         break;
                //     case (SERVICE_EDU):
                //         break;
                //     case (SERVICE_TRAVEL):
                //         break;
                // }
                // dd($post->posts_classify->services_type);
                return '';
                break;

            case (JOB):
                return'<div class="row d-flex justify-content-center mainPost-content-section">
                                                <div class="mainPost-content-title">
                                                    Chi Tiết
                                                </div>
                                                <br>
                                                <div class="row d-flex justify-content-center" style="width:100%; padding:0px;">
                                                    <div class="d-flex justify-content-center detail-sec">
                                                        <div style="width:50%;" class="d-flex justify-content-start ">
                                                            <p style="font-weight:bold;" >Nơi làm việc:</p>

                                                        </div>
                                                        <div style="width:50%;" class="d-flex justify-content-start ">
                                                            <p class="long-detail-wrap">' . (isset($post->posts_classify->address_working) ? $post->posts_classify->address_working : 'Liên hệ') . '</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center detail-sec">
                                                        <div style="width:50%;" class="d-flex justify-content-start">
                                                            <p style="font-weight:bold;" >Lương (&#8381) :</p>

                                                        </div>
                                                        <div style="width:50%;" class="d-flex justify-content-start">
                                                            <p class="long-detail-wrap">' . (isset($post->posts_classify->salary) ? $post->posts_classify->salary : 'Thương lượng') . '</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>';
                break;

            case (CAR_TRADE):
                return'<div class="row d-flex justify-content-center mainPost-content-section">
                                                <div class="mainPost-content-title">
                                                    Chi Tiết
                                                </div>
                                                <br>
                                                <div class="row d-flex justify-content-center" style="width:100%; padding:0px;">
                                                    <div class="d-flex justify-content-center detail-sec">
                                                        <div style="width:50%;" class="d-flex justify-content-start ">
                                                            <p style="font-weight:bold;" >Địa chỉ bán xe :</p>

                                                        </div>
                                                        <div style="width:50%;" class="d-flex justify-content-start ">
                                                            <p class="long-detail-wrap">' . (isset($post->posts_classify->address_trading) ? $post->posts_classify->address_trading : 'Liên hệ') . '</p>
                                                        </div>
                                                    </div>

                                                </div>
                                        </div>';
                break;

            case (RESTAURANT):
                return'<div class="row d-flex justify-content-center mainPost-content-section">
                                                    <div class="mainPost-content-title">
                                                        Chi Tiết
                                                    </div>
                                                    <br>
                                                    <div class="row d-flex justify-content-center" style="width:100%; padding:0px;">
                                                        <div class="d-flex justify-content-center detail-sec">
                                                            <div style="width:50%;" class="d-flex justify-content-start ">
                                                                <p style="font-weight:bold;" >Địa chỉ nhà hàng :</p>

                                                            </div>
                                                            <div style="width:50%;" class="d-flex justify-content-start ">
                                                                <p class="long-detail-wrap">' . (isset($post->posts_classify->restaurant_address) ? $post->posts_classify->restaurant_address : 'Liên hệ') . '</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-center detail-sec">
                                                            <div style="width:50%;" class="d-flex justify-content-start">
                                                                <p style="font-weight:bold;" >Hóa đơn trung bình (&#8381) :</p>

                                                            </div>
                                                            <div style="width:50%;" class="d-flex justify-content-start">
                                                                <p class="long-detail-wrap">' . (isset($post->posts_classify->average_bill) ? $post->posts_classify->average_bill : 'Liên hệ') . '</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                            </div>';
                break;

            case (AD):
                return'<div class="row d-flex justify-content-center mainPost-content-section">
                                                <div class="mainPost-content-title">
                                                    Chi Tiết
                                                </div>
                                                <br>
                                                <div class="row d-flex justify-content-center" style="width:100%; padding:0px;">
                                                    <div class="d-flex justify-content-center detail-sec">
                                                    <div style="width:50%;" class="d-flex justify-content-start ">
                                                        <p style="font-weight:bold;" >Thông tin quảng cáo :</p>

                                                    </div>
                                                    <div style="width:50%;" class="d-flex justify-content-start ">
                                                        <p class="long-detail-wrap">' . (isset($post->posts_classify->adContent) ? $post->posts_classify->adContent : 'Liên hệ') . '</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>';
                break;
        }
    }

    public function takePostById($postId)
    {
        $post = $this->postRepo->findById($postId);
        $post->update([
            'access_times' => isset($post->access_times) ? $post->access_times + 1 : 1,
        ]);
        $response['postDetail'] = $this->takePostDetailHTML($post ,$post->classify_id);

        $response['post'] = $post;

        // dd($post->posts_classify);

        return $response;
    }

    public function takeDataForEdit($postId){
        $response['post'] = $this->postRepo->findById($postId);
        $response['classify'] =  $response['post'] -> classify_id;
        $response['images']=[];
        $response['cities'] = $this->cityService->takeAllCity();

        foreach($response['post']->post_attachments as $image){
            array_push($response['images'], strval(asset($image->attachment_path)));
        }
        return $response;

    }
}
