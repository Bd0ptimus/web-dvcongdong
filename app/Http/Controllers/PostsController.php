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
        $postId = $request->route()->parameter('postId');

        $this->middleware('user.auth')->except(['mainPost','myPostLoadMore']);
        $this->middleware("mypost.permission:$userId")->only(['myPostIndex']);
        $this->middleware("editpost.permission:$postId")->only(['editPost']);

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
        $params['userId']=$userId;
        $posts = $this->postService->loadMyPost(0, $params);
        return view('post.myPost',['posts'=>$posts,
            'userId' => $userId
        ]);
    }

    public function myPostLoadMore(Request $request){
        $params['userId'] = request('userId');
        $data = [];

        try{
            $data = $this->postService->loadMoreMyPost(request('numberStep'), $params);

        }catch(\Exception $e){
            Log::debug('my post load error: '. $e );
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'load more my post thành công', 'data' => $data ]);
    }

    public function deletePost(Request $request){
        $data = [];
        try{
            $data = $this->postService->deletePost(request('postId'));
            if($data['permission_allow'] == 0){
                return response()->json(['error' => 1, 'msg' => 'Bạn không có quyền xóa bài viết này', 'data' => $data]);
            }else{
                if($data['error'] == 1){
                    return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
                }
            }
        }catch(\Exception $e){
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Xóa my post thành công', 'data' => $data ]);
    }

    public function editPost(Request $request, $postId){
        if($request->isMethod('POST')){
            $response = $this->postService->editPost($postId, $request);
            if($response['error'] == 0){
                $complete = 1;
            }else{
                $complete = 0;
            }
            return Redirect()->route('post.editConfirm',['postId'=>$postId, 'confirm'=>$complete]);
        }
        $data = $this->postService->takeDataForEdit($postId);
        return view('post.editPost',
            [
                'post'=>$data['post'],
                'classify'=>$data['classify'],
                'images'=>$data['images'],
                'cities'=>$data['cities']
            ]);

    }

    public function editConfirm(Request $request, $postId, $confirm){
        $post = $this->postService->takePostById($postId);
        return view('post.mainPost',['post'=> $post['post'], 'postDetail'=>$post['postDetail'], 'complete'=>$confirm]);
    }

    public function mainPost(Request $request, $postId){
        $post = $this->postService->takePostById($postId);
        return view('post.mainPost',['post'=> $post['post'], 'postDetail'=>$post['postDetail']]);
    }



}
