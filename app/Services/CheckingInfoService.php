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

}
