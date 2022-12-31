<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;

//model

//repo
use App\Repositories\CheckingInfoServiceRepository;

use Exception;
class CheckingInfoService
{
    protected $checkingInfoServiceRepo;

    public function __construct(CheckingInfoServiceRepository $checkingInfoServiceRepo){
        $this->checkingInfoServiceRepo = $checkingInfoServiceRepo;
    }


    public function addNewRequest($params){
        switch($params['checkingType']){
            case(CAR_TICKET_TYPE):
                $this->checkingInfoServiceRepo->addToCarTicketChecking($params);
                break;
            case(ENTRY_BAN_TYPE):
                $this->checkingInfoServiceRepo->addToEntryBanChecking($params);
                break;
            case(TAX_DEBT_TYPE):
                $this->checkingInfoServiceRepo->addToTaxDebtChecking($params);
                break;
            case(ADMINISTRATIVE_TYPE):
                $this->checkingInfoServiceRepo->addToAdminisChecking($params);

                break;
        }

    }

    public function removeResult($params){
        switch($params['checkingType']){
            case(CAR_TICKET_TYPE):
                $this->checkingInfoServiceRepo->removeCarTicketResult($params['id']);
                break;
            case(ENTRY_BAN_TYPE):
                $this->checkingInfoServiceRepo->removeEntryBanResult($params['id']);
                break;

            case(TAX_DEBT_TYPE):
                $this->checkingInfoServiceRepo->removeTaxDebtResult($params['id']);
                break;
            case(ADMINISTRATIVE_TYPE):
                $this->checkingInfoServiceRepo->removeAdminisResult($params['id']);
                break;
        }
    }

    public function removeRequirement($params){
        switch($params['checkingType']){
            case(CAR_TICKET_TYPE):
                $this->checkingInfoServiceRepo->removeCarTicketRequirement($params['id']);
                break;
            case(ENTRY_BAN_TYPE):
                $this->checkingInfoServiceRepo->removeEntryBanRequirement($params['id']);
                break;
            case(TAX_DEBT_TYPE):
                $this->checkingInfoServiceRepo->removeTaxDebtRequirement($params['id']);
                break;
            case(ADMINISTRATIVE_TYPE):
                $this->checkingInfoServiceRepo->removeAdminisRequirement($params['id']);
                break;
        }
    }

    public function loadAllCheckingRequest(){
        $carTicket = $this->checkingInfoServiceRepo->loadAllCarTicket();
        $entryBan =$this->checkingInfoServiceRepo->loadAllEntryBan();
        $taxDebt = $this->checkingInfoServiceRepo->loadAllTaxDebt();
        $adminis = $this->checkingInfoServiceRepo->loadAllAdminis();
        $response['carTickets']['created']=$carTicket['created'];
        $response['carTickets']['completed']=$carTicket['completed'];
        $response['entryBans']['created']=$entryBan['created'];
        $response['entryBans']['completed']=$entryBan['completed'];
        $response['taxDebt']['created'] = $taxDebt['created'];
        $response['taxDebt']['completed'] = $taxDebt['completed'];
        $response['adminis']['created'] =$adminis['created'];
        $response['adminis']['completed'] =$adminis['completed'];
        return $response;
    }

    public function carTicketResultUpdate($request){
        $this->checkingInfoServiceRepo->carTicketResultUpdate($request);
    }

    public function entryBanResultUpdate($request){
        $this->checkingInfoServiceRepo->entryBanResultUpdate($request);
    }

    public function taxDebtResultUpdate($request){
        $this->checkingInfoServiceRepo->taxDebtResultUpdate($request);

    }

    public function adminisResultUpdate($request){
        $this->checkingInfoServiceRepo->adminisResultUpdate($request);

    }

}
