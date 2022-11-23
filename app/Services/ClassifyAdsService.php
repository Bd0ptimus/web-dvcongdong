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
use App\Repositories\ClassifyAdsRepository;


use Exception;
class ClassifyAdsService
{
    protected $classifyAdsRepo;

    public function __construct(ClassifyAdsRepository $classifyAdsRepo){
        $this->classifyAdsRepo = $classifyAdsRepo;
    }


    public function uploadPostAds($request){
        return $this->classifyAdsRepo->adsPostCreate($request);
    }

    public function findPostAdsById($id){
        return $this->classifyAdsRepo->findById($id);
    }
}
