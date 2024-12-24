<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Business\ResponseService;
use Illuminate\Http\Request;
use DB;

class GoodsController extends Controller
{

    private $resp;

    public function __construct(ResponseService $resp)
    {
        $this->resp = $resp;
    }

    public function categoryList(Request $request, ResponseService $response)
    {
        $list = DB::table('tao_goods')->groupBy(['category'])->pluck('category')->toArray();

        return $response->returnData($list);
    }

    public function goodsList(Request $request, ResponseService $response)
    {
        $category = $request->input('category', '');
        $title    = $request->input('title', '');
        $limit    = $request->input('limit', 15);

        $model = DB::table('tao_goods');
        if ($category) {
            $model->where('category', $category);
        }
        if ($title) {
            $model->where('title', 'like', '%' . $title . '%');
        }

        $list = $model->paginate($limit);

        return $response->returnData($list);
    }

}