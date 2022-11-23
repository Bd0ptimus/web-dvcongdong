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
use App\Repositories\MomBabyRepository;


use Exception;
class MomBabyService
{
    protected $momBabyRepo;

    public function __construct(MomBabyRepository $momBabyRepo){
        $this->momBabyRepo = $momBabyRepo;
    }


    public function uploadPostMomBaby($request){
        return $this->momBabyRepo->momBabyPostCreate($request);
    }

    public function findPostMombabyById($id){
        return $this->momBabyRepo->findById($id);
    }
}
