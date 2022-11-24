<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Services
use App\Services\CheckingInfoService;

class CheckingInfoServiceController extends Controller
{

    protected $checkingInfoService;
    public function __construct(CheckingInfoService $checkingInfoService){
        $this->checkingInfoService = $checkingInfoService;
    }

    public function addNewRequest(Request $request){
        try{
            $params['checkingType'] = request('checkingType');
            $params['responseRequire'] = request('responseRequire');
            $params['userId'] = request('userId');

            \Log::debug('checkingType : ' .$params['checkingType']  );
            switch(request('checkingType')){
                case(CAR_TICKET_TYPE):
                    $params['carLicense'] = request('carLicense');
                    $params['certCarOwnerShip'] = request('certCarOwnerShip');
                    break;
                case(ENTRY_BAN_TYPE):
                    $params['nameRussian']=request('nameRussian');
                    $params['nameLatin'] = request('nameLatin');
                    $params['dob'] = request('dob');
                    $params['passportSeries'] = request('passportSeries');
                    $params['passportExpiredDate'] = request('passportExpiredDate');
                    break;
            }
            $this->checkingInfoService->addNewRequest($params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lưu thành công']);
    }
}
