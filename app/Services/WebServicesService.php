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
use App\Repositories\WebServicesRepository;


use Exception;
class WebServicesService
{
    protected $webServiceRepo;

    public function __construct(WebServicesRepository $webServiceRepo){
        $this->webServiceRepo = $webServiceRepo;
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
}
