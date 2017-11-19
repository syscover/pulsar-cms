<?php namespace Syscover\Cms\Controllers;

use Illuminate\Http\Request;
use Syscover\Cms\Services\CategoryService;
use Syscover\Core\Controllers\CoreController;
use Syscover\Cms\Models\Category;

class CategoryController extends CoreController
{
    protected $model = Category::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response['status'] = "success";
        $response['data']   = CategoryService::create($request->all());

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $response['status'] = "success";
        $response['data']   = CategoryService::update($request->all());

        return response()->json($response);
    }
}
