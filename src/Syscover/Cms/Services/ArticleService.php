<?php namespace Syscover\Cms\Services;

use Syscover\Admin\Services\AttachmentService;
use Syscover\Cms\Models\Article;

class ArticleService
{
    /**
     * @param array     $object     contain properties of article
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function create($object)
    {
        if(empty($object['id'])) $object['id'] = next_id(Article::class);

        // set values to transform
        // use preg_replace to format date from Google Chrome, attach (Hota de verano romance) string
        $object['data_lang'] = Article::addDataLang($object['lang_id'], $object['id']);

        // get custom fields
        if(isset($object['field_group_id'])) $object['data']['custom_fields'] = $object['custom_fields'];

        // create new object,
        // to create article execute method searcheable from scout to index in algolia
        $article = Article::create(ArticleService::builder($object));

        // get object with builder, to get every relations
        $article = Article::find($article->ix);

        // parse html and manage img of wysiwyg
        $html = AttachmentService::manageWysiwygAttachment($article->article, 'storage/app/public/cms/articles', 'storage/cms/articles', $article->id);

        if($html != null)
        {
            $article->article = $html;
            $article->save();
        }

        $article->categories()->sync($object['categories_id']);

        // set attachments
        if(is_array($object['attachments']))
        {
            // first save libraries to get id
            $attachments = AttachmentService::storeAttachmentsLibrary($object['attachments']);

            // then save attachments
            AttachmentService::storeAttachments($attachments, 'storage/app/public/cms/articles', 'storage/cms/articles', Article::class, $article->id,  $article->lang_id);
        }

        return $article;
    }

    /**
     * @param array     $object     contain properties of article
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public static function update($object)
    {
        // get custom fields
        if(isset($object['field_group_id'])) $object['data']['custom_fields'] = $object['custom_fields'];
        if(! empty($object['tags'])) $object['tags'] = json_encode($object['tags']);
        if(! empty($object['data'])) $object['data'] = json_encode($object['data']);

        Article::where('ix', $object['ix'])->update(ArticleService::builder($object));

        $article = Article::find($object['ix']);

        if(config('scout.driver') === 'algolia') $article->searchable();

        // parse html and manage img of wysiwyg
        $html = AttachmentService::manageWysiwygAttachment($article->article, 'storage/app/public/cms/articles', 'storage/cms/articles', $article->id);

        if($html != null)
        {
            $article->article = $html;
            $article->save();
        }

        $article->categories()->sync($object['categories_id']);

        // set attachments
        if(is_array($object['attachments']))
        {
            // first save libraries to get id
            $attachments = AttachmentService::storeAttachmentsLibrary($object['attachments']);

            // then save attachments
            AttachmentService::updateAttachments($attachments, 'storage/app/public/cms/articles', 'storage/cms/articles', Article::class, $article->id,  $article->lang_id);
        }

        return $article;
    }

    private static function builder($object)
    {
        $object = collect($object);
        $object = $object->only([
            'id',
            'lang_id',
            'name',
            'parent_id',
            'author_id',
            'section_id',
            'family_id',
            'status_id',
            'publish',
            'date',
            'title',
            'slug',
            'link',
            'blank',
            'tags',
            'sort',
            'excerpt',
            'article',
            'data_lang',
            'data'
        ]);

        if($object->has('publish')) $object['publish'] = date_time_string($object->get('publish'));
        if($object->has('date'))    $object['date'] = date_time_string($object->get('date'));

        return $object->toArray();
    }

    private static function check($object)
    {

    }
}