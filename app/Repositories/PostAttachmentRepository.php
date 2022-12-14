<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
//use Your Model
use App\Admin;

use App\Models\post_attachment;
/**
 * Class UserRepository.
 */
class PostAttachmentRepository extends BaseRepository
{
    protected $model;
    public function __construct(post_attachment $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */
    public function addNewAttachment($postId,$attachmentArr){
        //logo
        if(isset($attachmentArr['logo']) && !empty($attachmentArr['logo'])){
            $this->model->create([
                'attachment_path'=>'/storage/post_attachments/'.$attachmentArr['logo'],
                'post_id' => $postId,
                'attachment_type' => POST_LOGO,
            ]);
        }
        // dd($attachmentArr['desPhoto']);
        if(isset($attachmentArr['desPhoto']) && !empty($attachmentArr['desPhoto'])){
            foreach($attachmentArr['desPhoto'] as $desPhoto){
                $this->model->create([
                    'attachment_path'=>'/storage/post_attachments/'.$desPhoto,
                    'post_id' => $postId,
                    'attachment_type' => POST_DESCRIPTION_PHOTO,
                ]);
            }
        }
    }


}
