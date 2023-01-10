<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Repositories\BaseRepository;
use App\Repositories\PostAttachmentRepository;
use App\Repositories\PostCommentRepository;

use Illuminate\Support\Facades\Log;


//use Your Model
use App\Admin;

use App\Models\post;
use App\Models\real_estate;
use App\Models\service;
use App\Models\post_interaction;
/**
 * Class UserRepository.
 */
class PostRepository extends BaseRepository
{
    protected $model;
    protected $postAttachmentRepo;
    protected $postCommentRepo;
    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(post $model,
    PostAttachmentRepository $postAttachmentRepo,
    PostCommentRepository $postCommentRepo)
    {
        $this->model = $model;
        $this->postAttachmentRepo = $postAttachmentRepo;
        $this->postCommentRepo = $postCommentRepo;
    }
    /**
     * @return string
     *  Return the model
     */

    public function createNewPostBaseOnClassify($classifyRelation, $request, $classifyId)
    {
        if ($request->userChosenId != '' && Admin::user()->inRoles([ROLE_ADMIN, ROLE_SUPER_ADMIN])) {
            $user_id = $request->userChosenId ;
        } else {
            $user_id = Admin::user()->id;
        }

        $dateFrom = strtr(trim(explode('-', $request->daterange)[0]), '/', '-');
        $dateTo = strtr(trim(explode('-', $request->daterange)[1]), '/', '-');
        // dd(date("Y-m-d", strtotime($dateFrom)));
        // dd($request);
        $post = new post([
            'classify_id' => $classifyId,
            'user_id' => $user_id,
            'city_id' => $request->createPostCity,
            'title' => $request->title,
            'description' => $request->description,
            'exist_from' =>  date("Y-m-d", strtotime($dateFrom)),
            'exist_to' =>  date("Y-m-d", strtotime($dateTo)),
            'contact_address' => $request->contactAddress ?? '',
            'contact_phone_number' => $request->contactPhone,
            'access_times'=>0,
            'number_comment_accept'=>0,
            'rating_score'=>0,
        ]);

        $classifyRelation->post()->save($post);
        return $post;
    }


    public function loadPostsForNewFeed($numPage, $params = [])
    {

        $now = Carbon::now()->toDateString();
        $query = $this->model->newQuery();
        if($params['city'] > 0){
            $query=$query->where('city_id', $params['city']);
        }
        $query = $query->where('exist_from', '<=', $now)
            ->where('exist_to', '>=', $now);
        $query = $query->orderBy('updated_at', 'DESC');

        $query = $query->skip(NEW_FEED_LOAD_STEP * $numPage)->take(NEW_FEED_LOAD_STEP)->get();

        return  $query;
    }


    public function takeMostAccessPosts(){
        $now = Carbon::now()->toDateString();
        $query = $this->model->newQuery();

        $query = $query->where('exist_from', '<=', $now)
            ->where('exist_to', '>=', $now);
        $query = $query->orderBy('access_times', 'DESC');

        $query = $query->take(NUMBER_POST_MOST_ACCESSED)->get();

        return  $query;
    }


    public function findPostsWithCondition($filterData, $numPage = 0)
    {
        $query = $this->model;
        // dd($query->where('city_id', 1)->get());
        $now = Carbon::now()->toDateString();
        $query=$query->where('exist_from', '<=', $now)
            ->where('exist_to', '>=', $now);

        if ($filterData['position'] > 0) {
            // dd($filt erData['position'].' - '. $query->get()[0]->city_id);
            $query= $query->where('city_id', '=', $filterData['position']);
        }
        // dd($query->get());

        if ($filterData['classify'] > 0) {
            $query=$query->where('classify_id', $filterData['classify']);
            if($filterData['classify'] == SERVICE ){
                $serviceMatchs = service::where('classify_type_id',$filterData['classifyType'])->pluck('id')->toArray();
                $query=$query->whereHas('posts_classify', function ($query) use ($serviceMatchs){
                    $query->whereIn('id', $serviceMatchs );
                });
                // dd($query->with('posts_classify')->whereIn('id',$serviceMatchs)->get());
            }
        }
        // dd($query->get());
        if (isset($filterData['keyword'])) {
            $query=$query->Where('title', 'like', '%' . $filterData['keyword'] . '%') ;//->orWhere('description', 'like', '%' . $filterData['keyword'] . '%')
        }
        // dd($query->get());
        $query=$query->orderBy('updated_at', 'DESC');
        $query=$query->skip(NEW_FEED_LOAD_STEP * $numPage)->take(NEW_FEED_LOAD_STEP)->get();
        return $query;
    }


    public function addInteractPost($postId, $userId, $interact){
        switch($interact){
            case (NOT_INTERACT):
                $interactType =NOT_INTERACT;
                break;
            case (LIKE):
                $interactType =LIKE;
                break;
        }
        post_interaction::where('user_id', $userId)->where('post_id', $postId)->delete();
        $like=post_interaction::create([
            'user_id'=>$userId,
            'post_id'=>$postId,
            'interaction_type'=>$interactType,
        ]);
        return $like;
    }

    public function allPostLiked($userId){
        return $this->model->whereHas('post_interactions', function($query) use($userId){
            $query->where('user_id', $userId)->where('interaction_type', LIKE);
        })->get();
    }

    public function loadAllForMyPost($numPage, $params){
        $query = $this->model->newQuery();
        $query = $query->where('user_id',$params['userId']);
        $query=$query->orderBy('updated_at', 'DESC');
        $query=$query->skip(NEW_FEED_LOAD_STEP * $numPage)->take(NEW_FEED_LOAD_STEP)->get();
        return $query;
    }

    public function deleteAllPostById($postId, $relation){
        // Log::debug('check relation : '. print_r($relation, true));
        // exit;
        $relation->post()->delete();
        $this->postAttachmentRepo->deletePostAttachmentsByPostId($postId);
        $this->postCommentRepo->deleteWithPostId($postId);
    }

    public function findPostByCommentId($commentId){
        return $this->model->whereHas('postComments', function($query) use ($commentId){
            $query->where('id', $commentId);
        })->first();
    }

    public function updatePost($postId, $request){
        $post = $this->model->where('id', $postId)->first();

        switch($post->classify_id){
            case (REAL_ESTATE):
                $post->posts_classify->update([
                    'square'=>$request->realEstateSquare,
                    'address'=>$request->realEstateAddress,
                    'price' => $request->realEstatePrice,
                    'number_room' => $request->realEstateNumberRoom,
                ]);
                break;
            case (JOB):
                $post->posts_classify->update([
                    'address_working'=>$request->jobAddress,
                    'salary'=>$request->jobSalary,
                ]);
                break;
            case (CAR_TRADE):
                $post->posts_classify->update([
                    'address_trading'=>$request->carTradeAddress,
                ]);
                break;
            case (RESTAURANT):
                $post->posts_classify->update([
                    'restaurant_address'=>$request->restaurantAddress,
                    'average_bill'=>$request->restaurantAverageBill,
                ]);
                break;
            case (AD):
                $post->posts_classify->update([
                    'adContent'=>$request->adContent,
                ]);
                break;
        }
        $dateFrom = strtr(trim(explode('-', $request->daterange)[0]), '/', '-');
        $dateTo = strtr(trim(explode('-', $request->daterange)[1]), '/', '-');
        $post->update([
            'city_id'=> $request->createPostCity,
            'title'=> $request->title,
            'description'=>$request->description,
            'contact_phone_number' => $request->contactPhone,
            'exist_from' => date("Y-m-d", strtotime($dateFrom)),
            'exist_to' => date("Y-m-d", strtotime($dateTo)),
        ]);
        return $post;
    }
}
