<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\PostService;
use App\Services\WebServicesService;

use App\Models\classify_types;

class ServiceController extends Controller
{
    protected $postService;
    protected $webServicesService;

    public function __construct(PostService $postService,
    WebServicesService $webServicesService){
        $this->postService = $postService;
        $this->webServicesService = $webServicesService;
    }

    public function index(Request $request, $classifyType){
        $params['classify'] =SERVICE;
        $params['position']=0;
        $params['classifyType'] = $classifyType;
        $posts = $this->postService->searchPosts($params,0);
        $header = 'Dịch vụ '. classify_types::where('id',$classifyType)->first()->type_name;
        // dd($posts);
        return view('post.categories.services.index',[
            'posts' => $posts,
            'header' =>$header,
            'classifyId'=>$classifyType,
        ]);
    }

    public function loadMoreService(Request $request, $classifyType){
        $params['classify'] =SERVICE;
        $params['position']=0;
        $params['userId']=request('userId');
        $params['classifyType']=$classifyType;
        try{
            $response = $this->webServicesService->loadMoreService(request('numPage'), $params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lấy nha dat thanh cong', 'data'=>$response]);
    }
}
