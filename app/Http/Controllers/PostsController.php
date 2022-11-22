<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\LOG;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use App\Services\ClassifyService;
use App\Services\PostService;


use App\Admin;
class PostsController extends Controller
{
    protected $classifyService;
    protected $postService;

    public function __construct(Request $request,ClassifyService $classifyService,
    PostService $postService){
        // dd($request->route()->parameter('userId'));
        $userId = $request->route()->parameter('userId');
        $this->middleware('user.auth');
        $this->middleware("mypost.permission:$userId")->only(['myPostIndex']);
        $this->classifyService = $classifyService;
        $this->postService = $postService;
    }

    public function index(Request $request){
        if($request->isMethod('POST')){
            // dd($request->mainFilterClassify);
            $data=$this->postService->takeAllForCreatePost($request->mainFilterClassify, $request->mainFilterClassifyType??null);
            // dd($data);

            return view('post.newPostCreate', [
                'header' => $data['header'],
                'haveTitle' => $data['haveTitle'],
                'title' => $data['title']??null,
                'cities' => $data['cities'],
                'classify' => $data['classify'],
                'classifyType' => $data['classifyType']??0,
            ]);
        }
        $data=$this->postService->takeAllForChooseTopic();
        return view('post.chooseTopic', [
            'classifies'=>$data['classifies'],
            'header'=>$data['header']],
        );
    }

    public function checkTypeInsideClassify(Request $request){
        try{
            $data = $this->classifyService->checkTypeClassify(request('classifyId'));

        }catch(\Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'lấy data classify types thành công', 'data' => $data ]);

    }

    public function freeUpload(Request $request , $classify, $classifyType){
        $response = $this->postService->processUploadNewPost($request, $classify, $classifyType);
        return view('post.confirmPage', [
            'error' => $response['error'],
            'confirmText'=>$response['confirmText']??'',
        ]);
    }


    public function myPostIndex(Request $request, $userId){
        // dd($request->get('userId'));
        $posts = $this->postService->loadMyPost(0, $userId);
        return view('post.myPost',['posts'=>$posts,
            'userId' => $userId
        ]);
    }

    public function myPostLoadMore(Request $request){

    }

}
