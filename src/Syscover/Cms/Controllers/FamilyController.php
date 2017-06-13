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
        // create object
        $object = Family::create([
            'name'              => $request->input('name'),
            'editor_id'         => $request->input('editor_id'),
            'field_group_id'    => $request->input('field_group_id'),
            'date'              => $request->input('date'),
            'title'             => $request->input('title'),
            'slug'              => $request->input('slug'),
            'link'              => $request->input('link'),
            'categories'        => $request->input('categories'),
            'sort'              => $request->input('sort'),
            'tags'              => $request->input('tags'),
            'article_parent'    => $request->input('article_parent'),
            'attachments'       => $request->input('attachments')
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
        Family::where('id', $id)->update([
            'name'              => $request->input('name'),
            'editor_id'         => $request->input('editor_id'),
            'field_group_id'    => $request->input('field_group_id'),
            'date'              => $request->input('date'),
            'title'             => $request->input('title'),
            'slug'              => $request->input('slug'),
            'link'              => $request->input('link'),
            'categories'        => $request->input('categories'),
            'sort'              => $request->input('sort'),
            'tags'              => $request->input('tags'),
            'article_parent'    => $request->input('article_parent'),
            'attachments'       => $request->input('attachments')
        ]);

        $object = Family::find($request->input('id'));

        $response['status'] = "success";
        $response['data']   = $object;

        return response()->json($response);
    }
}
