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

    public function findServiceById($serviceId){
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
}
