<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\LOG;

use Illuminate\Support\Facades\Storage;

use App\Services\PostService;
use App\Services\AttachmentService;
use App\Services\AuthService;

use App\Repositories\UserRepository;

class UserAccountDetailController extends Controller
{

    protected $postService;
    protected $attachmentService;
    protected $userRepo;
    protected $authService;
    public function __construct(Request $request,
    PostService $postService,
    AttachmentService $attachmentService,
    UserRepository $userRepo,
    AuthService $authService){
        $userId = $request->route()->parameter('userId');
        $this->middleware("mypost.permission:$userId")->only(['changeDescription']);
        $this->postService = $postService;
        $this->attachmentService = $attachmentService;
        $this->userRepo = $userRepo;
        $this->authService = $authService;

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

    public function changeDescription(Request $request, $userId){
        $this->userRepo->updateDescription($userId, $request->description);
        return redirect()->back();
    }

    public function changeMainInfo(Request $request, $userId){
        $this->userRepo->updateMainInfo($userId, $request);
        return redirect()->back();
    }

    public function changePassword(Request $request){
        LOG::debug('in changePassword ' );

        try{
            $response = $this->authService->changePassword($request->userId, $request->oldPassword, $request->newPassword);
        }catch(\Exception $e){
            LOG::debug('update avatar : ' . $e );
            return response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Thay doi matkhau thanh cong', 'data'=>$response]);
    }
}
