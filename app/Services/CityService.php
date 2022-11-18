<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;

//model

//repo
use App\Repositories\CityRepository;

use Exception;
class CityService
{
    protected $cityRepo;

    public function __construct(CityRepository $cityRepo){
        $this->cityRepo = $cityRepo;
    }

    public function takeAllCity(){
        return $this->cityRepo->takeAllCity();

    }


}
