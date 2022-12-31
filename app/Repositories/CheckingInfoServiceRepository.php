<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Log;

//use Your Model
use App\Admin;

use App\Models\entry_ban_checking;
use App\Models\car_ticket_checking;
use App\Models\tax_debt_checking;
use App\Models\adminis_checking;

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

    public function addToTaxDebtChecking($params){
        tax_debt_checking::create([
            'user_id' => $params['userId'],
            'name'=>$params['name'],

            'dob' => date('Y-m-d',strtotime($params['dob'])),
            'passport_series' =>$params['passportSeries'],
            'passport_expired' =>date('Y-m-d',strtotime($params['passportExpiredDate'])),
            'inn'=>$params['inn'],
            'status' => CHECK_REQUEST_CREATED,
            'response_require' => $params['responseRequire'],
        ]);
    }

    public function addToAdminisChecking($params){
        adminis_checking::create([
            'user_id' => $params['userId'],
            'name'=>$params['name'],
            'dob' => date('Y-m-d',strtotime($params['dob'])),
            'passport_series' =>$params['passportSeries'],
            'passport_expired' =>date('Y-m-d',strtotime($params['passportExpiredDate'])),
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

    public function removeTaxDebtResult($id){
        tax_debt_checking::where('id', $id)->update([
            'result_comment' => '',
            'status'=>CHECK_REQUEST_CREATED,
        ]);
    }

    public function removeAdminisResult($id){
        adminis_checking::where('id', $id)->update([
            'result_comment' => '',
            'status'=>CHECK_REQUEST_CREATED,
        ]);
    }

    public function removeCarTicketRequirement($id){
        car_ticket_checking::where('id', $id)->delete();
    }

    public function removeEntryBanRequirement($id){
        entry_ban_checking::where('id', $id)->delete();
    }

    public function removeTaxDebtRequirement($id){
        tax_debt_checking::where('id', $id)->delete();
    }

    public function removeAdminisRequirement($id){
        adminis_checking::where('id', $id)->delete();
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

    public function loadAllTaxDebt(){
        $response['created'] = tax_debt_checking::with('user')->where('status', CHECK_REQUEST_CREATED)->orderBy('updated_at', 'DESC')->get();
        $response['completed'] = tax_debt_checking::with('user')->where('status', CHECK_REQUEST_COMPLETED)->orderBy('updated_at', 'DESC')->get();
        return $response;
    }

    public function loadAllAdminis(){
        $response['created'] = adminis_checking::with('user')->where('status', CHECK_REQUEST_CREATED)->orderBy('updated_at', 'DESC')->get();
        $response['completed'] = adminis_checking::with('user')->where('status', CHECK_REQUEST_COMPLETED)->orderBy('updated_at', 'DESC')->get();
        return $response;
    }

    public function carTicketResultUpdate($request){
        car_ticket_checking::where('id',$request->carTicketBtn)->update([
            'result_comment' => $request->carTicketModalResult,
            'status' => CHECK_REQUEST_COMPLETED
        ]);
    }

    public function entryBanResultUpdate($request){
        entry_ban_checking::where('id',$request->entryBanBtn)->update([
            'result_comment' => $request->entryBanModalResult,
            'status' => CHECK_REQUEST_COMPLETED
        ]);
    }

    public function taxDebtResultUpdate($request){
        tax_debt_checking::where('id',$request->taxDebtBtn)->update([
            'result_comment' => $request->taxDebtModalResult,
            'status' => CHECK_REQUEST_COMPLETED
        ]);
    }

    public function adminisResultUpdate($request){
        adminis_checking::where('id',$request->adminisBtn)->update([
            'result_comment' => $request->adminisModalResult,
            'status' => CHECK_REQUEST_COMPLETED
        ]);
    }

}
