<?php namespace Syscover\Admin\Controllers;

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
        // set custom fields
        $properties = [];
        if($request->has('field_group_id'))
        {
            $fields = Field::where('field_group_id', $request->input('field_group_id'))->get();
            foreach ($fields as $field)
            {
                $properties[$field->name] = $request->input($field->name);
            }
        }

        // create object
        $object = Family::create([
            'name'              => $request->input('name'),
            'editor_id'         => $request->input('name'),
            'field_group_id'    => $request->input('field_group_id'),
            'data'              => [
                'morphology'    => [
                    'date'          => $request->input('date'),
                    'title'         => $request->input('title'),
                    'slug'          => $request->input('slug'),
                    'link'          => $request->input('link'),
                    'categories'    => $request->input('categories'),
                    'sort'          => $request->input('sort'),
                    'tags'          => $request->input('tags')
                ],
                'properties'        => $properties
            ]
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
        // set custom fields
        $properties = [];
        if($request->has('field_group_id'))
        {
            $fields = Field::where('field_group_id', $request->input('field_group_id'))->get();
            foreach ($fields as $field)
            {
                $properties[$field->name] = $request->input($field->name);
            }
        }

        // update object
        Family::where('id', $id)->update([
            'name'              => $request->input('name'),
            'editor_id'         => $request->input('name'),
            'field_group_id'    => $request->input('field_group_id'),
            'data'              => json_encode([
                'morphology'    => [
                    'date'          => $request->input('date'),
                    'title'         => $request->input('title'),
                    'slug'          => $request->input('slug'),
                    'link'          => $request->input('link'),
                    'categories'    => $request->input('categories'),
                    'sort'          => $request->input('sort'),
                    'tags'          => $request->input('tags')
                ],
                'properties'        => $properties
            ])
        ]);

        $object = Family::find($request->input('id'));

        $response['status'] = "success";
        $response['data']   = $object;

        return response()->json($response);
    }
}
