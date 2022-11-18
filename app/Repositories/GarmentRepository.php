<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\garment;
/**
 * Class UserRepository.
 */
class GarmentRepository extends BaseRepository
{
    protected $model;
    public function __construct(garment $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */

    public function garmentPostCreate($request){
        $garment = new garment([
            'information'=>$request->garmentInfo??null,
        ]);
        $garment->save();
        return $garment;
    }







}
