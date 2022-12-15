<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;

//model
use App\Models\service_document;
use App\Models\service_edu;
use App\Models\service_medical;
use App\Models\service_electronic;
use App\Models\service_travel;
use App\Models\service;


//services
use App\Services\CityService;
use App\Services\ClassifyService;

//repo
use App\Repositories\WebServicesRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;



use Exception;
class WebServicesService
{
    protected $webServiceRepo;
    protected $postRepo;
    protected $userRepo;
    public function __construct(WebServicesRepository $webServiceRepo,
    PostRepository $postRepo,
    UserRepository $userRepo){
        $this->webServiceRepo = $webServiceRepo;
        $this->postRepo = $postRepo;
        $this->userRepo = $userRepo;
    }


    public function uploadPostService($request, $classifyType){
        switch($classifyType){
            case (SERVICE_DOCUMENT):
                $serviceRelation = $this->webServiceRepo->serviceDocumentPostCreate($request);
                break;
            case (SERVICE_MEDICAL):
                $serviceRelation = $this->webServiceRepo->serviceMedicalPostCreate($request);
                break;
            case (SERVICE_EDU):
                $serviceRelation = $this->webServiceRepo->serviceEduPostCreate($request);
                break;
            case (SERVICE_TRAVEL):
                $serviceRelation = $this->webServiceRepo->serviceTravelPostCreate($request);
                break;
            case (SERVICE_ELECTRONIC):
                $serviceRelation = $this->webServiceRepo->serviceElectronicPostCreate($request);
                break;
        }
        return $this->webServiceRepo->servicePostCreate($serviceRelation , $request, $classifyType);
    }

    public function deleteService($serviceId){
        $classifyType = service::where('id',  $serviceId)->first();
        Log::debug('classifyType : ' . $classifyType->classify_type_id . ' - services_type_id : '.$classifyType->services_type_id);
        switch($classifyType->classify_type_id){
            case (SERVICE_DOCUMENT):
                $serviceRelation = service_document::where('id', $classifyType->services_type_id)->first();
                break;
            case (SERVICE_MEDICAL):
                $serviceRelation = service_medical::where('id', $classifyType->services_type_id)->first();
                break;
            case (SERVICE_EDU):
                $serviceRelation = service_edu::where('id', $classifyType->services_type_id)->first();
                break;
            case (SERVICE_TRAVEL):
                $serviceRelation = service_travel::where('id',$classifyType->services_type_id)->first();
                break;
            case (SERVICE_ELECTRONIC):
                $serviceRelation = service_electronic::where('id', $classifyType->services_type_id)->first();
                break;
        }
        $this->webServiceRepo->deleteService($serviceRelation);
    }

    public function loadMoreService($numPage,$params){

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
