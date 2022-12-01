<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\PostService;
use App\Services\RealEstateService;

class RealEstateController extends Controller
{

    protected $postService;
    protected $realEstateService;

    public function __construct(PostService $postService,
    RealEstateService $realEstateService){
        $this->postService = $postService;
        $this->realEstateService = $realEstateService;
    }

    public function index(){
        $params['classify'] =REAL_ESTATE;
        $params['position']=0;
        $posts = $this->postService->searchPosts($params,0);
        return view('post.categories.realEstate.index',[
            'posts' => $posts,
        ]);
    }

    public function loadMoreRealEstate(Request $request){
        $params['classify'] =REAL_ESTATE;
        $params['position']=0;
        $params['userId']=request('userId');

        try{
            $response = $this->realEstateService->loadMoreRealEstate(request('numPage'), $params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lấy nha dat thanh cong', 'data'=>$response]);
    }
}
