<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\PostService;
use App\Services\SearchService;
use App\Services\HomeService;



class SearchingController extends Controller
{
    protected $postService;
    protected $searchService;
    protected $homeService;
    public function __construct(PostService $postService,
    SearchService $searchService,
    HomeService $homeService){
        $this->postService = $postService;
        $this->searchService = $searchService;
        $this->homeService = $homeService;
    }

    public function index(){
        $dataForHome=$this->homeService->loadAllForHomePage();
        $filterData['keyword'] = null;
        $filterData['classify'] = 0;
        $filterData['position'] = 0;
        $posts = $this->postService->searchPosts($filterData);
        return view('search.index', [
            'posts'=>$posts,
            'keywordChoosen'=>$filterData['keyword']??'',
            'classifyChoosen'=>$filterData['classify'],
            "positionChoosen" => $filterData['position'],
            'classifies'=>$dataForHome['classifies'],
            'cities'=>$dataForHome['cities'],
        ]);
    }

    public function searchingLoading(Request $request){
        $filterData['keyword'] = request('keyword');
        $filterData['classify'] = request('classify');
        $filterData['position'] = request('position');
        $filterData['userId'] = request('userId');
        $numberStep = request('numberStep');
        try{
            $response = $this->searchService->searchNewFeedLoading($filterData, $numberStep);
        }catch(Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'Lấy search thành công', 'data'=>$response]);
    }



    public function searchAction(Request $request){
        $dataForHome=$this->homeService->loadAllForHomePage();
        $filterData['keyword'] = $request->homeFilterKeyWord;
        $filterData['classify'] = $request->homeFilterClassify;
        $filterData['position'] = $request->homeFilterPosition;
        $posts = $this->postService->searchPosts($filterData);
        return view('search.index', [
            'posts'=>$posts,
            'keywordChoosen'=>$filterData['keyword']??'',
            'classifyChoosen'=>$filterData['classify'],
            "positionChoosen" => $filterData['position'],
            'classifies'=>$dataForHome['classifies'],
            'cities'=>$dataForHome['cities'],
        ]);
    }
}
