<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\entry_ban_checking;
use App\Models\car_ticket_checking;
/**
 * Class UserRepository.
 */
class CheckingInfoServiceRepository extends BaseRepository
{
    protected $model;
    /**
     * @return string
     *  Return the model
     */
    public function __construct(entry_ban_checking $model){
        $this->model = $model;
    }

    public function addToEntryBanChecking($params){
        entry_ban_checking::create([
            'name_russian'=>$params['nameRussian'],
            'name_latin' =>$params['nameLatin'],
            'dob' =>$params['dob'],
            'status' => CHECK_REQUEST_CREATED,
            'passport_series' => $params['passportSeries'],
            'passport_expired' =>$params['passportExpiredDate'],
        ]);
    }

    public function addToCarTicketChecking($params){
        car_ticket_checking::create([
            'car_license' => $params['carLicense'],
            'car_ownership_certificate' =>$params['certCarOwnerShip'],
            'status' => CHECK_REQUEST_CREATED,
        ]);
    }




}
