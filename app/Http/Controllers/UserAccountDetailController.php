<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\LOG;

use Illuminate\Support\Facades\Storage;

use App\Services\PostService;
use App\Services\AttachmentService;
use App\Repositories\UserRepository;

class UserAccountDetailController extends Controller
{

    protected $postService;
    protected $attachmentService;
    protected $userRepo;
    public function __construct(Request $request,PostService $postService, AttachmentService $attachmentService, UserRepository $userRepo){
        $userId = $request->route()->parameter('userId');
        $this->middleware("mypost.permission:$userId")->only(['myPostIndex']);
        $this->postService = $postService;
        $this->attachmentService = $attachmentService;
        $this->userRepo = $userRepo;

    }
    public function index(Request $request, $userId){
        $params['userId']=$userId;
        $posts = $this->postService->loadMyPost(0, $params);
        $user = $this->userRepo->findById($userId);
        return view('user.index',['posts'=>$posts,
            'userId' => $userId,
            'user'=>$user,
        ]);
    }

    public function changeAvatar(Request $request){
        LOG::debug('image uploaded : ' . print_r($request->changeAvatar,true) );

        try{
            $avatarPath = $this->attachmentService->changeAvatar($request->changeAvatar,$request->userId );
        }catch(\Exception $e){
            LOG::debug('update avatar : ' . $e );
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Thay doi avatar thanh cong', 'data'=>$avatarPath]);
    }
}
