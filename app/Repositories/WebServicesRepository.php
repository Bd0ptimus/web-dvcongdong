<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\service_document;
use App\Models\service_edu;
use App\Models\service_medical;
use App\Models\service_electronic;
use App\Models\service_travel;
use App\Models\service;

/**
 * Class UserRepository.
 */
class WebServicesRepository extends BaseRepository
{
    protected $model;
    public function __construct(service $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */

    public function servicePostCreate($serviceRelation, $request,$classifyType){
        $service = new service([
            'classify_type_id' =>$classifyType,
        ]);
        $serviceRelation->service()->save($service);
        return $service;
    }


    public function serviceDocumentPostCreate($request){
        $serviceDoc = new service_document([
            'content' => $request->serviceContent??null,
        ]);
        $serviceDoc->save();
        return $serviceDoc;
    }

    public function serviceMedicalPostCreate($request){
        $serviceMedic = new service_medical([
            'content' => $request->serviceContent??null,
        ]);
        $serviceMedic->save();
        return $serviceMedic;
    }

    public function serviceEduPostCreate($request){
        $serviceEdu = new service_edu([
            'content' => $request->serviceContent??null,
        ]);
        $serviceEdu->save();
        return $serviceEdu;
    }

    public function serviceTravelPostCreate($request){
        $serviceTravel = new service_travel([
            'content' => $request->serviceContent??null,
        ]);
        $serviceTravel->save();
        return $serviceTravel;
    }

    public function serviceElectronicPostCreate($request){
        $serviceElec = new service_electronic([
            'content' => $request->serviceContent??null,
        ]);
        $serviceElec->save();
        return $serviceElec;
    }

    public function deleteService($relation){
        return $relation->service()->delete();
    }



}
