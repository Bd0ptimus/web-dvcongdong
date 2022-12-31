<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;
use App\Mail\CheckingService;
use Illuminate\Support\Facades\log;

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

            Log::debug('checkingType : ' .print_r($params, true) );
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
                case(TAX_DEBT_TYPE):
                    $params['name'] = request('name');
                    $params['dob'] = request('dob');
                    $params['passportSeries'] = request('passportSeries');
                    $params['passportExpiredDate'] = request('passportExpiredDate');
                    $params['inn'] = request('inn');
                    break;

                case(ADMINISTRATIVE_TYPE):
                    $params['name'] = request('name');
                    $params['dob'] = request('dob');
                    $params['passportSeries'] = request('passportSeries');
                    $params['passportExpiredDate'] = request('passportExpiredDate');
                    break;
            }
            $this->checkingInfoService->addNewRequest($params);
        }catch(\Exception $e){
            Log::debug('Error in add checking request : '. $e);
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lưu thành công']);
    }

    public function adminIndex(Request $request){
        $data=$this->checkingInfoService->loadAllCheckingRequest();
        return view('checkingService.checkingServiceManager',[
            'carTickets'=>$data['carTickets'],
            'entryBans'=>$data['entryBans'],
            'taxDebt'=>$data['taxDebt'],
            'adminis'=>$data['adminis'],
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

    public function taxDebtResultUpdate(Request $request){
        $this->checkingInfoService->taxDebtResultUpdate($request);
        if($request->taxDebtModalResponseOption == RESPONSE_VIA_EMAIL){
            // dd($request);
            Mail::to($request->taxDebtModalResponseAddress)->send(new CheckingService('Kiểm Tra Nợ Thuế', $request->taxDebtModalNameRequester, $request->taxDebtModalResult));
        }elseif($request->taxDebtModalResponseOption == RESPONSE_VIA_PHONE){

        }
        return redirect()->back();
    }

    public function adminisResultUpdate(Request $request){
        $this->checkingInfoService->adminisResultUpdate($request);
        if($request->adminisModalResponseOption == RESPONSE_VIA_EMAIL){
            // dd($request);
            Mail::to($request->adminisModalResponseAddress)->send(new CheckingService('Kiểm Tra Lỗi Hành Chính', $request->adminisModalNameRequester, $request->adminisModalResult));
        }elseif($request->adminisModalResponseOption == RESPONSE_VIA_PHONE){

        }
        return redirect()->back();
    }


    public function removeResult(Request $request){
        try{
            $params['checkingType'] = request('checkingType');
            $params['id'] = request('id');
            $this->checkingInfoService->removeResult($params);
        }catch(\Exception $e){
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'remove thành công']);
    }

    public function removeRequirement(Request $request){
        try{
            $params['checkingType'] = request('checkingType');
            $params['id'] = request('id');
            $this->checkingInfoService->removeRequirement($params);
        }catch(\Exception $e){
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'remove thành công']);
    }
}
