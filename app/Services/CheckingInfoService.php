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
        }
    }

    public function loadAllCheckingRequest(){
        $response['carTickets']['created']=$this->checkingInfoServiceRepo->loadAllCarTicket()['created'];
        $response['carTickets']['completed']=$this->checkingInfoServiceRepo->loadAllCarTicket()['completed'];
        $response['entryBans']['created']=$this->checkingInfoServiceRepo->loadAllEntryBan()['created'];
        $response['entryBans']['completed']=$this->checkingInfoServiceRepo->loadAllEntryBan()['completed'];
        return $response;
    }

    public function carTicketResultUpdate($request){
        $this->checkingInfoServiceRepo->carTicketResultUpdate($request);
    }

}
