<?php namespace Syscover\Cms\Controllers;

use Illuminate\Http\Request;
use Syscover\Core\Controllers\CoreController;
use Syscover\Cms\Models\Section;
use Syscover\Cms\Services\SectionService;

class SectionController extends CoreController
{
    protected $model = Section::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response['status'] = "success";
        $response['data']   = SectionService::createService($request->all());

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   int     $id
     * @return  \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $response['status'] = "success";
        $response['data']   = SectionService::updateService($request->all(), $id);

        return response()->json($response);
    }
}
