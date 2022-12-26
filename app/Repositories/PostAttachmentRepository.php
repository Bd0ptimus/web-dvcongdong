<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;

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


    public function deletePostAttachmentsByPostId($postId){
        // $this->model->where('post_id', $postId)->delete();
        $images=$this->model->where('post_id', $postId)->get();
        foreach($images as $image){
            if(File::exists(public_path($image->attachment_path))){
                File::delete(public_path($image->attachment_path));
            }
            $image->delete();
        }

    }

    public function checkAttachmentExistedInPost($postId, $name){
        $images = $this->model->where('post_id', $postId)->where('attachment_path', 'LIKE', '%'.$name.'%')->first();
        return count($images) > 0 ;
    }




}
