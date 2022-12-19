<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\real_estate;
/**
 * Class UserRepository.
 */
class RealEstateRepository extends BaseRepository
{
    protected $model;
    public function __construct(real_estate $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */

    public function realEstatePostCreate($request){
        $realEstate = new real_estate([
            'square'=>$request->realEstateSquare,
            'address'=>$request->realEstateAddress,
            'price'=>$request->realEstatePrice,
            'number_room'=>$request->realEstateNumberRoom,
        ]);
        $realEstate->save();

        return $realEstate;
    }








}
