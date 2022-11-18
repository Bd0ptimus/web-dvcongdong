<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\car_trade;
/**
 * Class UserRepository.
 */
class CarTradeRepository extends BaseRepository
{
    protected $model;
    public function __construct(car_trade $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */

    public function carTradePostCreate($request){
        $carTrade = new car_trade([
            'address_trading'=>$request->carTradeAddress??null,
        ]);
        $carTrade->save();
        return $carTrade;
    }







}
