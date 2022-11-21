<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Repositories\BaseRepository;
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
    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(post $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */

    public function createNewPostBaseOnClassify($classifyRelation, $request, $classifyId)
    {
        if (isset($request->createdByAdmin)) {
            $user_id = 0;
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
        $query = $query->orderBy('created_at', 'DESC');

        $query = $query->skip(NEW_FEED_LOAD_STEP * $numPage)->take(NEW_FEED_LOAD_STEP)->get();

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
        }
        // dd($query->get());
        if (isset($filterData['keyword'])) {
            $query=$query->Where('title', 'like', '%' . $filterData['keyword'] . '%') ;//->orWhere('description', 'like', '%' . $filterData['keyword'] . '%')
        }
        // dd($query->get());
        $query=$query->orderBy('created_at', 'DESC');
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
}
