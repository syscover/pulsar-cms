<?php namespace Syscover\Cms\Services;

use Carbon\Carbon;
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
        if(empty($object['id']))
        {
            $id = Article::max('id');
            $id++;
            $object['id'] = $id;
        }

        // set values to transform
        // use preg_replace to format date from Google Chrome, attach (Hota de verano romance) string
        $object['data_lang'] = Article::addDataLang($object['lang_id'], $object['id']);

        // get custom fields
        if(isset($object['field_group_id'])) $object['data']['customFields'] = $object['customFields'];

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
        if(isset($object['field_group_id'])) $object['data']['customFields'] = $object['customFields'];
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
        $data = [];

        if($object->has('id'))                      $data['id'] = $object->get('id');
        if($object->has('name'))                    $data['name'] = $object->get('name');
        if($object->has('parent_id'))               $data['parent_id'] = $object->get('parent_id');
        if($object->has('author_id'))               $data['author_id'] = $object->get('author_id');
        if($object->has('section_id'))              $data['section_id'] = $object->get('section_id');
        if($object->has('family_id'))               $data['family_id'] = $object->get('family_id');
        if($object->has('status_id'))               $data['status_id'] = $object->get('status_id');
        if($object->has('publish'))                 $data['publish'] = date_time_string($object->get('publish'));
        if($object->has('date'))                    $data['date'] = date_time_string($object->get('date'));
        if($object->has('title'))                   $data['title'] = $object->get('title');
        if($object->has('slug'))                    $data['slug'] = $object->get('slug');
        if($object->has('link'))                    $data['link'] = $object->get('link');
        if($object->has('blank'))                   $data['blank'] = $object->get('blank');
        if($object->has('tags'))                    $data['tags'] = $object->get('tags');
        if($object->has('sort'))                    $data['sort'] = $object->get('sort');
        if($object->has('excerpt'))                 $data['excerpt'] = $object->get('excerpt');
        if($object->has('article'))                 $data['article'] = $object->get('article');
        if($object->has('data_lang'))               $data['data_lang'] = $object->get('data_lang');
        if($object->has('data'))                    $data['data'] = $object->get('data');

        return $data;
    }

    private static function check($object)
    {

    }
}