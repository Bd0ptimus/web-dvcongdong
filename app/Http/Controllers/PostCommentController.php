<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\PostCommentService;

class PostCommentController extends Controller
{
    protected $postCommentService;
    public function __construct(PostCommentService $postCommentService){
        $this->middleware('admin.permission')->only(['adminIndex', 'adminCommentInteract']);
        $this->postCommentService = $postCommentService;
    }
    public function addNewComment(Request $request){
        LOG::debug('image uploaded : ' . $request->TotalFiles );
        LOG::debug('rating : ' . $request->postRating );
        LOG::debug('postCommentText : ' . $request->postCommentText );
        LOG::debug('userId : ' . $request->userId );
        $params['postCommentText']=$request->postCommentText ;
        $params['userId']=$request->userId ;
        $params['rating']=$request->postRating;
        $params['images']=[];
        if($request->TotalFiles>0){
            for ($x = 0; $x < $request->TotalFiles; $x++)
           {
               if ($request->hasFile('files'.$x))
                {
                    array_push($params['images'],$request->file('files'.$x) );
                    LOG::debug('file  : '.$x.' : ' .$request->file('files'.$x) );
                }
           }
        }
        try{
            $this->postCommentService->addPostComment($request->postId, $params);
        }catch(\Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'comment thành công']);
    }

    public function loadComment(Request $request){
        $postId = request('postId');
        $step = request('step');
        $data = [];
        // $data = $this->postCommentService->loadPostComment($postId, $step);
        try{
            $data = $this->postCommentService->loadPostComment($postId, $step);
        }catch(\Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'load comment thành công', 'data'=>$data]);
    }

    public function loadCommentTest(Request $request, $postId, $step){
        $data = [];
        $data = $this->postCommentService->loadPostComment($postId, $step);
        try{
            $data = $this->postCommentService->loadPostComment($postId, $step);
        }catch(\Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'load comment thành công', 'data'=>$data]);
    }

    public function adminIndex(Request $request){
        $data = $this->postCommentService->takeCommentForCmtManager();
        return view('post.admin.comment.commentManager', [
            'cmtsPending'=>$data['cmtsPending'],
            'cmtsAccepted'=>$data['cmtsAccepted'],
            'cmtsRejected'=>$data['cmtsRejected'],

        ]);
    }

    public function adminCommentInteract(Request $request, $commentId, $status){
        $this->postCommentService->changeCmtStatus($commentId, $status);
        return redirect()->back();
    }
}
