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
use App\Repositories\CarTradeRepository;


use Exception;
class CarTradeService
{
    protected $carTradeRepo;

    public function __construct(CarTradeRepository $carTradeRepo){
        $this->carTradeRepo = $carTradeRepo;
    }


    public function uploadPostCarTrade($request){
        return $this->carTradeRepo->carTradePostCreate($request);
    }
}
