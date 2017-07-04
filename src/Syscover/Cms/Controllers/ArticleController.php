<?php namespace Syscover\Cms\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Syscover\Admin\Models\Field;
use Syscover\Admin\Services\AttachmentService;
use Syscover\Cms\Models\Tag;
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
        // get custom fields
        $data = [];
        if($request->has('field_group_id'))
        {
            $fields = Field::where('field_group_id', $request->input('field_group_id'))->get();
            foreach ($fields as $field)
            {
                $data['properties'][$field->name] = $request->input($field->name);
            }
        }

        // check if there is id
        if($request->has('id'))
        {
            $id = $request->input('id');
        }
        else
        {
            $id = Article::max('id');
            $id++;
        }

        $object = Article::create([
            'id'                    => $id,
            'lang_id'               => $request->input('lang_id'),
            'name'                  => $request->input('name'),
            'parent_article_id'     => $request->input('parent_article_id'),
            'author_id'             => $request->input('author_id'),
            'section_id'            => $request->input('section_id'),
            'family_id'             => $request->input('family_id'),
            'status_id'             => $request->input('status_id'),
            'publish'               => empty($request->input('publish'))? null : (new Carbon($request->input('publish')))->toDateTimeString(),
            'date'                  => empty($request->input('date'))? null : (new Carbon($request->input('date')))->toDateTimeString(),
            'title'                 => $request->input('title'),
            'slug'                  => $request->input('slug'),
            'link'                  => $request->input('link'),
            'blank'                 => $request->input('blank'),
            'sort'                  => $request->input('sort'),
            'article'               => $request->input('article'),
            'data_lang'             => Article::addLangDataRecord($request->input('lang_id'), $id),
            'data'                  => $data
        ]);

        // get object with builder, to get every relations
        $object = Article::builder()->where('id', $object->id)->where('lang_id', $object->lang_id)->first();

        $this->setTags($object, $request);
        $this->setCategories($object, $request);

        // set attachments
        if(is_array($request->input('attachments')))
        {
            // first save libraries to get id
            $attachments = AttachmentService::storeAttachmentsLibrary($request->input('attachments'));

            // then save attachments
            AttachmentService::storeAttachments($attachments, 'storage/app/public/cms/articles', 'storage/cms/articles', $this->model, $object->id,  $object->lang_id);
        }

        $response['status'] = "success";
        $response['data']   = $object;

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
        // get custom fields
        $data = [];
        if(isset($request->input('family')['field_group_id']))
        {
            $fields = Field::where('field_group_id', $request->input('family')['field_group_id'])->get();
            foreach ($fields as $field)
            {
                $data['properties'][$field->name] = $request->input($field->name);
            }
        }

        Article::where('id', $id)->where('lang_id', $lang)->update([
            'name'                  => $request->input('name'),
            'parent_article_id'     => $request->input('parent_article_id'),
            'author_id'             => $request->input('author_id'),
            'section_id'            => $request->input('section_id'),
            'family_id'             => $request->input('family_id'),
            'status_id'             => $request->input('status_id'),
            'publish'               => empty($request->input('publish'))? null : (new Carbon($request->input('publish')))->toDateTimeString(),
            'date'                  => empty($request->input('date'))? null : (new Carbon($request->input('date')))->toDateTimeString(),
            'title'                 => $request->input('title'),
            'slug'                  => $request->input('slug'),
            'link'                  => $request->input('link'),
            'blank'                 => $request->input('blank'),
            'sort'                  => $request->input('sort'),
            'article'               => $request->input('article'),
            'data'                  => json_encode($data)
        ]);

        $object = Article::where('id', $id)->where('lang_id', $lang)->first();

        $this->setTags($object, $request);
        $this->setCategories($object, $request);

        // set attachments
        if(is_array($request->input('attachments')))
        {
            // first save libraries to get id
            $attachments = AttachmentService::storeAttachmentsLibrary($request->input('attachments'));

            // then save attachments
            AttachmentService::updateAttachments($attachments, 'storage/app/public/cms/articles', 'storage/cms/articles', $this->model, $object->id,  $object->lang_id);
        }

        $response['status'] = "success";
        $response['data']   = $object;

        return response()->json($response);
    }

    private function setTags($object, $request)
    {
        if(is_array($request->input('tags')) && count($request->input('tags')) > 0)
        {
            $tagsArray  = array_unique($request->input('tags'));
            $tagsId       = [];
            foreach ($tagsArray as $tag)
            {
                $tagObj = Tag::create([
                    'lang_id'   => $request->input('lang_id'),
                    'name'      => $tag
                ]);
                $tagsId[] = $tagObj->id;
            }

            $object->tags()->sync($tagsId);
        }
    }

    private function setCategories($object, $request)
    {
        $object->categories()->sync($request->input('categories_id'));
    }
}
