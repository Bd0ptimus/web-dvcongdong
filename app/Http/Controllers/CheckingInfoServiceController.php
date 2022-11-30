<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;
use App\Mail\CheckingService;
//Services
use App\Services\CheckingInfoService;

class CheckingInfoServiceController extends Controller
{

    protected $checkingInfoService;
    public function __construct(CheckingInfoService $checkingInfoService){
        $this->middleware('user.auth');
        $this->middleware('admin.permission')->only(['adminIndex']);
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

    public function adminIndex(Request $request){
        $data=$this->checkingInfoService->loadAllCheckingRequest();
        return view('checkingService.checkingServiceManager',[
            'carTickets'=>$data['carTickets'],
            'entryBans'=>$data['entryBans'],
        ]);
    }

    public function carTicketResultUpdate(Request $request){
        $this->checkingInfoService->carTicketResultUpdate($request);
        if($request->carTicketModalResponseOption == RESPONSE_VIA_EMAIL){
            Mail::to($request->carTicketModalResponseAddress)->send(new CheckingService('Kiểm Tra Lỗi Phạt Xe', $request->carTicketModalNameRequester, $request->carTicketModalResult));
        }elseif($request->carTicketModalResponseOption == RESPONSE_VIA_PHONE){

        }
        return redirect()->back();
    }

    public function entryBanResultUpdate(Request $request){
        $this->checkingInfoService->entryBanResultUpdate($request);
        if($request->entryBanModalResponseOption == RESPONSE_VIA_EMAIL){
            Mail::to($request->entryBanModalResponseAddress)->send(new CheckingService('Kiểm Tra Cấm nhập cảnh', $request->entryBanModalNameRequester, $request->entryBanModalResult));
        }elseif($request->entryBanModalResponseOption == RESPONSE_VIA_PHONE){

        }
        return redirect()->back();
    }

    public function removeResult(Request $request){
        try{
            $params['checkingType'] = request('checkingType');
            $params['id'] = request('id');
            $this->checkingInfoService->removeResult($params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'remove thành công']);
    }

    public function removeRequirement(Request $request){
        try{
            $params['checkingType'] = request('checkingType');
            $params['id'] = request('id');
            $this->checkingInfoService->removeRequirement($params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'remove thành công']);
    }
}
