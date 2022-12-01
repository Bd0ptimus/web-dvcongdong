<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\PostService;
use App\Services\ClassifyAdsService;

class ClassifyAdsController extends Controller
{
    protected $postService;
    protected $adService;

    public function __construct(PostService $postService,
    ClassifyAdsService $adService){
        $this->postService = $postService;
        $this->adService = $adService;
    }

    public function index(){
        $params['classify'] =AD;
        $params['position']=0;
        $posts = $this->postService->searchPosts($params,0);
        return view('post.categories.ad.index',[
            'posts' => $posts,
        ]);
    }

    public function loadMoreAd(Request $request){
        $params['classify'] =AD;
        $params['position']=0;
        $params['userId']=request('userId');

        try{
            $response = $this->adService->loadMoreAd(request('numPage'), $params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lấy nha dat thanh cong', 'data'=>$response]);
    }
}
