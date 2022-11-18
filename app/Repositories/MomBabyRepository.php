<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\mom_baby;
/**
 * Class UserRepository.
 */
class MomBabyRepository extends BaseRepository
{
    protected $model;
    public function __construct(mom_baby $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */

    public function momBabyPostCreate($request){
        $momBaby = new mom_baby([
            'information'=>$request->momBabyInfo??null,
        ]);
        $momBaby->save();
        return $momBaby;
    }







}
