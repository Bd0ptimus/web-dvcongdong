<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\city;
/**
 * Class UserRepository.
 */
class CityRepository extends BaseRepository
{
    protected $model;
    public function __construct(city $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */


    public function takeAllCity(){
        return $this->model->all();
    }


}
