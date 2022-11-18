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
use App\Repositories\JobRepository;


use Exception;
class JobService
{
    protected $jobRepo;

    public function __construct(JobRepository $jobRepo){
        $this->jobRepo = $jobRepo;
    }


    public function uploadPostJob($request){
        return $this->jobRepo->jobPostCreate($request);
    }
}
