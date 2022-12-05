<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\restaurant;
/**
 * Class UserRepository.
 */
class RestaurantRepository extends BaseRepository
{
    protected $model;
    public function __construct(restaurant $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */

    public function momBabyPostCreate($request){
        $restaurant = new restaurant([
            'restaurant_address'=>$request->restaurantAddress??null,
            'average_bill'=>$request->restaurantAverageBill??null,
        ]);
        $restaurant->save();
        return $restaurant;
    }







}
