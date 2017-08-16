<?php namespace Syscover\Cms\Controllers;

use Illuminate\Http\Request;
use Syscover\Core\Controllers\CoreController;
use Syscover\Admin\Models\Field;
use Syscover\Cms\Models\Family;

class FamilyController extends CoreController
{
    protected $model = Family::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response['status'] = "success";
        $response['data']   = FamilyService::create($request->all());

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
        $response['data']   = FamilyService::update($request->all(), $id);

        return response()->json($response);
    }
}
