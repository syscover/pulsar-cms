<?php namespace Syscover\Cms\Controllers;

use Illuminate\Http\Request;
use Syscover\Core\Controllers\CoreController;
use Syscover\Cms\Models\Section;

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
        // create object
        $object = Section::create([
            'id'                => $request->input('id'),
            'name'              => $request->input('name'),
            'article_family_id' => $request->input('family_id')
        ]);

        $response['status'] = "success";
        $response['data']   = $object;

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
        // update object
        Section::where('id', $id)->update([
            'id'                => $request->input('id'),
            'name'              => $request->input('name'),
            'article_family_id' => $request->input('family_id')
        ]);

        $object = Section::find($request->input('id'));

        $response['status'] = "success";
        $response['data']   = $object;

        return response()->json($response);
    }
}
