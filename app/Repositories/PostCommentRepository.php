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
                'post_id'=>$params['postId'],
                'writer_id'=>$params['userId'],
                'comments' => $params['postCommentText'],
                'star' => $params['rating'],
                'comment_accept'=>COMMENT_PENDING,
            ]);

            if(isset($params['images'])){
                for ($x = 0; $x < sizeof($params['images']); $x++)
                {
                    $path = $params['images'][$x]->store('public/post_attachments');
                    $name = $this->attachmentService->generateName();

                    $insert[$x]['post_comment_id'] =  $newComment->id;
                    $insert[$x]['attachment_path'] = $path;
                }

                post_comment_attachment::insert($insert);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::debug('error in save new comment : '. $e);
        }
    }

}
