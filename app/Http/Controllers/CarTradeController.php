<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\PostService;
use App\Services\CarTradeService;

class CarTradeController extends Controller
{
    protected $postService;
    protected $carTradeService;

    public function __construct(PostService $postService,
    CarTradeService $carTradeService){
        $this->postService = $postService;
        $this->carTradeService = $carTradeService;
    }

    public function index(){
        $params['classify'] =CAR_TRADE;
        $params['position']=0;
        $posts = $this->postService->searchPosts($params,0);
        return view('post.categories.carTrade.index',[
            'posts' => $posts,
        ]);
    }

    public function loadMoreCarTrade(Request $request){
        $params['classify'] =CAR_TRADE;
        $params['position']=0;
        $params['userId']=request('userId');

        try{
            $response = $this->carTradeService->loadMoreCarTrade(request('numPage'), $params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lấy nha dat thanh cong', 'data'=>$response]);
    }
}
