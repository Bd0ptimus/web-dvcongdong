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
use App\Repositories\RestaurantRepository;


use Exception;
class RestaurantService
{
    protected $restaurantRepo;

    public function __construct(RestaurantRepository $restaurantRepo){
        $this->restaurantRepo = $restaurantRepo;
    }


    public function uploadPostRestaurant($request){
        return $this->restaurantRepo->momBabyPostCreate($request);
    }
}
