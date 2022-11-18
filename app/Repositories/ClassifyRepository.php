<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\classify;

/**
 * Class UserRepository.
 */
class ClassifyRepository extends BaseRepository
{
    protected $model;

    public function __construct(classify $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */


    public function takeAllClassify(){
        return $this->model->all();
    }

    public function takeClassifyWithTypes($classifyId,$classifyTypeId){
        return $this->model->where('id', $classifyId)->with(['classifyTypes'=>function($query) use ($classifyTypeId){
            $query->where('id',$classifyTypeId)->first();
        }])->first();
    }
}
