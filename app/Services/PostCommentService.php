<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;

//model

//services
use App\Services\CityService;
use App\Services\ClassifyService;

//repo
use App\Repositories\PostCommentRepository;





use Exception;
class PostCommentService
{

    protected $postCommentRepo;
    public function __construct(PostCommentRepository $postCommentRepo){
        $this->postCommentRepo = $postCommentRepo;
    }

    public function addPostComment($postId, $params){

        $this->postCommentRepo->addNewPostComment($postId, $params);
    }

}
