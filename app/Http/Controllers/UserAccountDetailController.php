<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\LOG;

use Illuminate\Support\Facades\Storage;

use App\Services\PostService;
use App\Services\AttachmentService;
class UserAccountDetailController extends Controller
{

    protected $postService;
    protected $attachmentService;
    public function __construct(Request $request,PostService $postService, AttachmentService $attachmentService){
        $userId = $request->route()->parameter('userId');
        $this->middleware("mypost.permission:$userId")->only(['myPostIndex']);
        $this->postService = $postService;
        $this->attachmentService = $attachmentService;
    }

    public function index(Request $request, $userId){
        $params['userId']=$userId;
        $posts = $this->postService->loadMyPost(0, $params);
        return view('user.index',['posts'=>$posts,
            'userId' => $userId
        ]);
    }

    public function changeAvatar(Request $request){
        LOG::debug('image uploaded : ' . print_r($request->changeAvatar,true) );
        // $desPhotoName = $this->attachmentService->generateName() . '.jpg';
        // $request->changeAvatar->move(storage_path('app/public/post_attachments'), $desPhotoName);
        $base64_image = $request->changeAvatar; // your base64 encoded
        @list($type, $file_data) = explode(';', $base64_image);
        @list(, $file_data) = explode(',', $file_data);
        $imageName = $this->attachmentService->generateName().'.'.'png';
        Storage::disk('local')->put($imageName, base64_decode($file_data));

        LOG::debug('name : ' . $imageName );

    }
}
