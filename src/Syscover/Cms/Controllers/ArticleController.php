<?php namespace Syscover\Cms\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Syscover\Admin\Models\Field;
use Syscover\Admin\Services\AttachmentService;
use Syscover\Cms\Models\Tag;
use Syscover\Cms\Services\ArticleService;
use Syscover\Core\Controllers\CoreController;
use Syscover\Cms\Models\Article;

class ArticleController extends CoreController
{
    protected $model = Article::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response['status'] = "success";
        $response['data']   = ArticleService::create($request->all());

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   int     $id
     * @param   string  $lang
     * @return  \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id, $lang)
    {
        $response['status'] = "success";
        $response['data']   = ArticleService::update($request->all(), $id, $lang);

        return response()->json($response);
    }
}
