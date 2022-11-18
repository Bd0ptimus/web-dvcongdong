<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\classify_ads;
/**
 * Class UserRepository.
 */
class ClassifyAdsRepository extends BaseRepository
{
    protected $model;
    public function __construct(classify_ads $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */

    public function adsPostCreate($request){
        $classifyAds = new classify_ads([
            'adContent'=>$request->adContent??null,
        ]);
        $classifyAds->save();
        return $classifyAds;
    }







}
