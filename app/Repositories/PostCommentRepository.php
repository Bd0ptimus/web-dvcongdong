<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Repositories\BaseRepository;
use App\Repositories\PostAttachmentRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



//use Your Model
use App\Admin;

use App\Models\post_comment;
use App\Models\post_comment_attachment;
use App\Models\real_estate;
use App\Models\service;
use App\Models\post_interaction;

use App\Services\AttachmentService;


/**
 * Class UserRepository.
 */
class PostCommentRepository extends BaseRepository
{
    protected $model;
    protected $postAttachmentRepo;
    protected $attachmentService;
    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(post_comment $model, AttachmentService $attachmentService)
    {
        $this->model = $model;
        $this->attachmentService = $attachmentService;
    }
    /**
     * @return string
     *  Return the model
     */

    public function deleteWithPostId($postId){
        $this->model->where('post_id', $postId)->delete();
    }

    public function addNewPostComment($postId, $params){
        DB::beginTransaction();
        try{
            $newComment = $this->model->create([
                'post_id'=>$postId,
                'writer_id'=>$params['userId'],
                'comments' => $params['postCommentText'],
                'star' => $params['rating'],
                'comment_accept'=>COMMENT_PENDING,
            ]);

            if(!empty($params['images'])){
                for ($x = 0; $x < sizeof($params['images']); $x++)
                {
                    $name = $this->attachmentService->generateName().'.jpg';
                    $path = $params['images'][$x]->storeAs('public/post_attachments/',$name);

                    $insert[$x]['post_comment_id'] =  $newComment->id;
                    $insert[$x]['attachment_path'] = POST_IMAGE_DIR.$name;
                }

                post_comment_attachment::insert($insert);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::debug('error in save new comment : '. $e);
        }
    }

    public function countNumberRecord($postId){
        return count($this->model->where('post_id', $postId)->where('comment_accept', COMMENT_ACCEPTED)->get());
    }

    public function loadPostCommentWithStep($postId, $step){
        $query = $this->model->newQuery();
        $query = $query->where('post_id', $postId)->where('comment_accept', COMMENT_ACCEPTED)->with(['postCommentAttachments','user']);
        $query = $query->orderBy('created_at', 'DESC');
        $query = $query->skip(NUMBER_COMMENT_IN_STEP*$step)->take(NUMBER_COMMENT_IN_STEP)->get();
        return $query;
    }

    public function takeCmtByAcceptedStatus($status){
        return $this->model->with(['user', 'post', 'post.post_attachments','post.user','postCommentAttachments'])->where('comment_accept', $status)->get();
    }

    public function changeCmtStatus($commentId, $status, $postId){
        $this->model->where('id', $commentId)->update([
            'comment_accept'=>$status,
        ]);

        return $this->model->where('post_id', $postId)->where('comment_accept', COMMENT_ACCEPTED)->get();
    }

}
