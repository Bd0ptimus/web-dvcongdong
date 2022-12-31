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
use App\Repositories\PostRepository;





use Exception;
class PostCommentService
{

    protected $postCommentRepo;
    protected $postRepo;
    public function __construct(PostCommentRepository $postCommentRepo,PostRepository $postRepo){
        $this->postCommentRepo = $postCommentRepo;
        $this->postRepo = $postRepo;
    }

    public function addPostComment($postId, $params){

        $this->postCommentRepo->addNewPostComment($postId, $params);
    }

    public function loadPostComment($postId, $step){
        $comments = $this->postCommentRepo->loadPostCommentWithStep($postId, $step);

        $commentInterfaceSec = [];
        foreach ($comments as $comment){
            $writerAva = asset($comment->user->user_avatar);
            $writerName= $comment->user->name;

            $now = \Carbon\Carbon::now();
            $createdAt = \Carbon\Carbon::parse($comment->created_at);
            $commentDay = $createdAt->diffInDays($now);
            if ($commentDay == 0) {
                $commentDay = $createdAt->diffInHours($now);
                if ($commentDay == 0) {
                    $commentDay = 'gần đây';
                } else {
                    $commentDay = $commentDay . ' giờ trước';
                }
            } elseif ($commentDay > 30) {
                $commentDay = date('d/m/Y', strtotime($createdAt));
            } else {
                $commentDay = $commentDay . ' ngày trước';
            }

            $ratingStar = '';
            for($i=1; $i<=5; $i++){
                if($i<=$comment->star){
                    $ratingStar = $ratingStar.' <span class="fa fa-star rating-star-checked"
                    style="width:auto; padding:0px; margin:0px;"></span>';
                }else{
                    $ratingStar = $ratingStar.' <span class="fa fa-star"
                    style="width:auto; padding:0px; margin:0px;"></span>';
                }
            }

            $commentImage='';
            foreach($comment->postCommentAttachments as $attachment){
                $url= asset($attachment->attachment_path);
                $onclick = "watchImageModal('{$url}')";
                $commentImage= $commentImage."<div class='preview-image-sec'>
                                                    <img class='upload-image' onclick={$onclick} src='{$url}' alt='logo upload'>
                                                </div>";
            }

            $commentSec = "<div class='row w-100 mx-0 comment-sec my-1'>
                            <div class='m-1 d-flex justify-content-start comment-post-sec'>
                                <div class='vertical-container' style='width:40px;'>
                                    <div class='row comment-avatar-sec vertical-element-middle-align' onclick='openUserPage(".$comment->user->id.")'>
                                        <img class='comment-avatar' src=".$writerAva.">
                                    </div>
                                </div>
                                <div class='row mx-2 comment-writer-name-sec vertical-container'>
                                    <p class='vertical-element-middle-align'
                                        style='font-size : 14px; font-weight : 900; cursor:pointer;' onclick='openUserPage(".$comment->user->id.")'>
                                        ".$writerName."
                                        <br>
                                        <span style='font-size:12px;'><i class='fa-solid fa-clock'></i>".$commentDay."</span>
                                    </p>
                                </div>

                                <div class='row mx-2 comment-writer-rating vertical-container'>
                                    <div class='vertical-element-middle-align'>
                                       ".$ratingStar."
                                    </div>
                                </div>
                            </div>

                            <div class='row m-1 d-flex justify-content-start'>
                                <p class='newFeed-info-text2' style='margin-left:60px; font-size : 10px;'>
                                    ".nl2br($comment->comments)."</p>
                            </div>

                            <div class='row m-1 d-flex justify-content-center'>
                                ".$commentImage."
                            </div>
                        </div>";

            array_push($commentInterfaceSec,$commentSec );
        }

        $response['commentsInterface'] = $commentInterfaceSec;
        $totalNumberRecord = $this->postCommentRepo->countNumberRecord($postId);
        $maxNumberRecordFollowStep = ($step+1)*NUMBER_COMMENT_IN_STEP;
        if($maxNumberRecordFollowStep <$totalNumberRecord){
            $response['hasNextComments'] = true;
            $response['nextStep'] = $step+1;

        }else{
            $response['hasNextComments'] = false;
        }
        return $response;
    }


    public function takeCommentForCmtManager(){
        $response['cmtsPending'] = $this->postCommentRepo->takeCmtByAcceptedStatus(COMMENT_PENDING);
        $response['cmtsAccepted'] = $this->postCommentRepo->takeCmtByAcceptedStatus(COMMENT_ACCEPTED);
        $response['cmtsRejected'] = $this->postCommentRepo->takeCmtByAcceptedStatus(COMMENT_REJECTED);
        return $response;
    }

    private function handlePostRating($postComments, $post){
        if(count($postComments) == 0){
            $this->postRepo->update($post->id, [
                'rating_score'=>0,
                'number_comment_accept' => 0,
            ]);
        }else{
            $totalStar = 0;
            $validCmtHaveStar = count($postComments);
            foreach($postComments as $comment){
                if(isset($comment->star)){
                    $totalStar = $totalStar  + $comment->star;
                }else{
                    $validCmtHaveStar --;
                }
            }

            $postRating =round( $totalStar/$validCmtHaveStar ,0);
            $this->postRepo->update($post->id, [
                'rating_score'=>$postRating,
                'number_comment_accept' => count($postComments),
            ]);
        }

    }

    public function changeCmtStatus($commentId, $status){
        $post = $this->postRepo->findPostByCommentId($commentId);
        $postComments = $this->postCommentRepo->changeCmtStatus($commentId, $status, $post->id);
        $this->handlePostRating($postComments,$post);
    }

}
