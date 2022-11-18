<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Services\PostService;

class InteractionController extends Controller
{

    protected $postService;
    public function __construct(PostService $postService){
        $this->postService = $postService;
    }

    public function likePost(Request $request){
        Log::debug('in like post : '. request('userId'));
        try{
            $response = $this->postService->likePost(request('postId'), request('userId'));
            if($response['error'] == 1){
                return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
            }
        }catch(\Exception $e){
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Đã like thành công', 'data' => $response ]);
    }
}
