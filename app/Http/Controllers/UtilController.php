<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\LOG;

use App\Services\SearchService;

class UtilController extends Controller
{
    protected $searchService;
    public function __construct(SearchService $searchService){
        $this->searchService = $searchService;
    }
    public function searchUser(Request $request){
        try{
            $response=$this->searchService->searchUser($request);
        }catch(\Exception $e){
            LOG::debug('update avatar : ' . $e );
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Search user thanh cong', 'data' => $response]);
    }
}
