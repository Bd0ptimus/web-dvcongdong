<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;

//model

//repo
use App\Repositories\ClassifyRepository;

use Exception;
class ClassifyService
{
    protected $classifyRepo;

    public function __construct(ClassifyRepository $classifyRepo){
        $this->classifyRepo = $classifyRepo;
    }

    public function takeAllClassify(){
        return $this->classifyRepo->takeAllClassify();
    }

    public function takeClassifyWithTypes($classifyId,$classifyTypeId){
        return $this->classifyRepo->takeClassifyWithTypes($classifyId,$classifyTypeId);
    }

    public function takeClassifyById($id){
        return $this->classifyRepo->findById($id);
    }

    public function checkTypeClassify($classifyId){
        $classifyData['classifyTypes'] = $this->classifyRepo->findById($classifyId,['id', 'classify_name'],['classifyTypes']);
        $classifyData['haveChildType'] = sizeof( $classifyData['classifyTypes']->classifyTypes) > 0 ;
        return $classifyData;
    }

}
