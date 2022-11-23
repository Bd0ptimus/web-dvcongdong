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
use App\Repositories\GarmentRepository;


use Exception;
class GarmentService
{
    protected $garmentRepo;

    public function __construct(GarmentRepository $garmentRepo){
        $this->garmentRepo = $garmentRepo;
    }


    public function uploadPostGarment($request){
        return $this->garmentRepo->garmentPostCreate($request);
    }

    public function findPostGarmentById($id){
        return $this->garmentRepo->findById($id);
    }
}
