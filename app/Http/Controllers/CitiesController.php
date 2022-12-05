<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


use App\Services\CityService;
class CitiesController extends Controller
{
    protected $cityService;
    public function __construct(CityService $cityService){
        $this->cityService = $cityService;
    }
    public function index(Request $request){
        try{
            if(Cookie::get('nguoiviettainga-cities') == null){
                $data['cookies_existed']=false;
                $data['cities'] = $this->cityService->takeAllCity();
                Cookie::queue('nguoiviettainga-cities', json_encode($data['cities']), COOKIE_TIME_VALID);
            }else{
                $data['cookies_existed']=true;
            }
        }catch(\Exception$e){
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lấy tp thành công', 'data'=>$data]);

    }
}
