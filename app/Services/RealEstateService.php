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


use Exception;
class RealEstateService
{
    protected $realEstateRepo;

    public function __construct(RealEstateRepository $realEstateRepo){
        $this->realEstateRepo = $realEstateRepo;
    }


    public function uploadPostRealEstate($request){
        return $this->realEstateRepo->realEstatePostCreate($request);
    }
}
