<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\HomeService;
use App\Services\PostService;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $homeService;
    protected $postService;
    public function __construct(HomeService $homeService,
    PostService $postService)
    {
        // $this->middleware('auth');
        $this->homeService = $homeService;
        $this->postService = $postService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->isMethod('POST')){
            $cityChoosing = $request->mainCity;
        }else{
            $cityChoosing = 0;

        }
        $params['city'] = $cityChoosing;
        $dataForHome=$this->homeService->loadAllForHomePage();
        $posts = $this->postService->loadForNewFeed(0,$params);
        // dd($request->cookie('nguoiviettainga-position'));

        // dd($posts[0]->posts_classify);
        // dd($dataForHome);
        return response()->view('home', ['classifies'=>$dataForHome['classifies'],
            'cities'=>$dataForHome['cities'],
            'isHome'=>true,
            'posts' =>$posts,
            'cityChoosen' =>$cityChoosing,
        ]);
    }



    public function newFeedLoading(Request $request){
        $numberStep = request('numberStep');
        $params['city'] = request('cityChoosing');
        try{
            $response = $this->homeService->newFeedLoading($numberStep, $params);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lấy ảnh thành công', 'data'=>$response]);
    }


}
