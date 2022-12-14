<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;

//model

//repo
use App\Repositories\PostAttachmentRepository;

use Exception;
class AttachmentService
{
    protected $postAttachmentRepo;

    public function __construct(PostAttachmentRepository $postAttachmentRepo){
        $this->postAttachmentRepo = $postAttachmentRepo;
    }

    private function generateName(){
        $length = 50;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzQWERTYUIOPASDFGHJKLZXCVBNM';
        $string = "";
        for ($p = 0; $p < $length; $p++) {
            @$string .= $characters[mt_rand(0, strlen($characters))];
        }
        return $string;
    }

    public function addNewPostAttachments($postId,$request){

        //logo
        if(isset($request->logoUpload)){
            $logoName = $this->generateName().'.'.$request->logoUpload->extension();
            $request->logoUpload->move(storage_path('app/public/post_attachments') , $logoName);
            $data['logo'] = $logoName;
        }

        //description photo
        if(isset($request->desPhotoUpload)){
            $data['desPhoto']=[];
            foreach($request->desPhotoUpload as $desPhoto){
                $desPhotoName = $this->generateName().'.'.$desPhoto->extension();
                $desPhoto->move(storage_path('app/public/post_attachments') , $desPhotoName);
                array_push($data['desPhoto'], $desPhotoName);
            }
        }
        if(isset($data)){
            $this->postAttachmentRepo->addNewAttachment($postId, $data);
        }
        // return $data;
    }


}
