<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\job;
/**
 * Class UserRepository.
 */
class JobRepository extends BaseRepository
{
    protected $model;
    public function __construct(job $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */

    public function jobPostCreate($request){
        $job = new job([
            'address_working'=>$request->jobAddress??null,
            'salary'=>$request->jobSalary??null,
        ]);
        $job->save();
        return $job;
    }







}
