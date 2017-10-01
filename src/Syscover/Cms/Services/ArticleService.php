<?php namespace Syscover\Cms\Services;

use Carbon\Carbon;
use Syscover\Admin\Services\AttachmentService;
use Syscover\Cms\Models\Article;
use Syscover\Cms\Models\Tag;

class ArticleService
{
    /**
     * @param array     $object     contain properties of article
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function create($object)
    {
        // check if there is id
        if(empty($object['id']))
        {
            $id = Article::max('id');
            $id++;
            $object['id'] = $id;
        }

        // set values to transform
        $object['publish'] = empty($object['publish'])? null : (new Carbon($object['publish'], config('app.timezone')))->toDateTimeString();
        $object['date'] = empty($object['date'])? null : (new Carbon($object['date'], config('app.timezone')))->toDateTimeString();
        $object['data_lang'] = Article::addLangDataRecord($object['lang_id'], $id);

        // get custom fields
        if(isset($object['field_group_id'])) $object['data']['customFields'] = $object['customFields'];

        // create new object
        $article = Article::create($object);

        // get object with builder, to get every relations
        $article = Article::builder()
            ->where('cms_article.id', $article->id)
            ->where('cms_article.lang_id', $article->lang_id)
            ->first();

        // parse html and manage img of wysiwyg
        $html = AttachmentService::manageWysiwygAttachment($article->article, 'storage/app/public/cms/articles', 'storage/cms/articles', $article->id);

        if($html != null)
        {
            $article->article = $html;
            $article->save();
        }

        ArticleService::setTags($article, $object, false);
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
     * @param int       $id         old id of section
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public static function update($object, $id, $lang)
    {
        $object = collect($object);

        // get custom fields
        $data = [];
        if($object->has('field_group_id')) $data['customFields'] = $object->get('customFields');

        Article::where('id', $object->get('id'))
            ->where('lang_id', $object->get('lang_id'))
            ->update([
                'name'                  => $object->get('name'),
                'parent_article_id'     => $object->get('parent_article_id'),
                'author_id'             => $object->get('author_id'),
                'section_id'            => $object->get('section_id'),
                'family_id'             => $object->get('family_id'),
                'status_id'             => $object->get('status_id'),
                'publish'               => $object->has('publish') ? (new Carbon($object->get('publish'), config('app.timezone')))->toDateTimeString() : null,
                'date'                  => $object->has('date') ? (new Carbon($object->get('date'), config('app.timezone')))->toDateTimeString() : null,
                'title'                 => $object->get('title'),
                'slug'                  => $object->get('slug'),
                'link'                  => $object->get('link'),
                'blank'                 => $object->get('blank'),
                'sort'                  => $object->get('sort'),
                'excerpt'               => $object->get('excerpt'),
                'article'               => $object->get('article'),
                'data'                  => json_encode($data)
            ]);

        $article = Article::where('cms_article.id', $object->get('id'))
            ->where('cms_article.lang_id', $object->get('lang_id'))
            ->first();

        // parse html and manage img of wysiwyg
        $html = AttachmentService::manageWysiwygAttachment($article->article, 'storage/app/public/cms/articles', 'storage/cms/articles', $article->id);

        if($html != null)
        {
            $article->article = $html;
            $article->save();
        }

        ArticleService::setTags($article, $object, true);
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

    private static function setTags($article, $object, $destroyPreviousTags = false)
    {
        if($destroyPreviousTags && $article->tags->count() > 0)
        {
            Tag::whereIn('id', $article->tags->pluck('id'))
                ->delete();
        }

        if(is_array($object['tags']) && count($object['tags']) > 0)
        {
            $tags = [];
            foreach (array_unique($object['tags']) as $tag)
            {
                $tags[] = new Tag([
                    'lang_id'   => $object['lang_id'],
                    'name'      => $tag
                ]);
            }
            $article->tags()->saveMany($tags);
        }
    }
}