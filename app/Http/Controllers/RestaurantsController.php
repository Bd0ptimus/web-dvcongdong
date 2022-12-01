<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Services\RestaurantService;
class RestaurantsController extends Controller
{
    protected $postService;
    protected $restaurantService;

    public function __construct(PostService $postService,
    RestaurantService $restaurantService){
        $this->postService = $postService;
        $this->restaurantService = $restaurantService;
    }

    public function index(){
        $params['classify'] =RESTAURANT;
        $params['position']=0;
        $posts = $this->postService->searchPosts($params,0);
        return view('post.categories.restaurant.index',[
            'posts' => $posts,
        ]);
    }

    public function loadMoreRestaurant(Request $request){
        $params['classify'] =RESTAURANT;
        $params['position']=0;
        $params['userId']=request('userId');

        try{
            $response = $this->restaurantService->loadMoreRestaurant(request('numPage'), $params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lấy nha dat thanh cong', 'data'=>$response]);
    }
}
