<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Log;

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
            'user_id' =>$params['userId'],
            'name_russian'=>$params['nameRussian'],
            'name_latin' =>$params['nameLatin'],
            'dob' =>date('Y-m-d',strtotime($params['dob'])),
            'status' => CHECK_REQUEST_CREATED,
            'passport_series' => $params['passportSeries'],
            'passport_expired' =>date('Y-m-d',strtotime($params['passportExpiredDate'])),
            'response_require' => $params['responseRequire'],
        ]);
    }

    public function addToCarTicketChecking($params){
        car_ticket_checking::create([
            'user_id' =>$params['userId'],
            'car_license' => $params['carLicense'],
            'car_ownership_certificate' =>$params['certCarOwnerShip'],
            'status' => CHECK_REQUEST_CREATED,
            'response_require' => $params['responseRequire'],
        ]);
    }

    public function removeCarTicketResult($id){
        car_ticket_checking::where('id', $id)->update([
            'result_comment' => '',
            'status'=>CHECK_REQUEST_CREATED,
        ]);
    }

    public function removeEntryBanResult($id){
        entry_ban_checking::where('id', $id)->update([
            'result_comment' => '',
            'status'=>CHECK_REQUEST_CREATED,
        ]);
    }


    public function loadAllCarTicket(){
        $response['created'] = car_ticket_checking::with('user')->where('status', CHECK_REQUEST_CREATED)->orderBy('updated_at', 'DESC')->get();
        $response['completed'] = car_ticket_checking::with('user')->where('status', CHECK_REQUEST_COMPLETED)->orderBy('updated_at', 'DESC')->get();
        return $response;
    }

    public function loadAllEntryBan(){
        $response['created'] = entry_ban_checking::with('user')->where('status', CHECK_REQUEST_CREATED)->orderBy('updated_at', 'DESC')->get();
        $response['completed'] = entry_ban_checking::with('user')->where('status', CHECK_REQUEST_COMPLETED)->orderBy('updated_at', 'DESC')->get();
        return $response;
    }

    public function carTicketResultUpdate($request){
        car_ticket_checking::where('id',$request->carTicketBtn)->update([
            'result_comment' => $request->carTicketModalResult,
            'status' => CHECK_REQUEST_COMPLETED
        ]);
    }

}
