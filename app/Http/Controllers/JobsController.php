<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\PostService;
use App\Services\JobService;

class JobsController extends Controller
{
    protected $postService;
    protected $JobService;

    public function __construct(PostService $postService,
    JobService $JobService){
        $this->postService = $postService;
        $this->JobService = $JobService;
    }

    public function index(){
        $params['classify'] =JOB;
        $params['position']=0;
        $posts = $this->postService->searchPosts($params,0);
        return view('post.categories.job.index',[
            'posts' => $posts,
        ]);
    }

    public function loadMoreJob(Request $request){
        $params['classify'] =JOB;
        $params['position']=0;
        $params['userId']=request('userId');
        try{
            $response = $this->JobService->loadMoreJob(request('numPage'), $params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lấy nha dat thanh cong', 'data'=>$response]);
    }
}
