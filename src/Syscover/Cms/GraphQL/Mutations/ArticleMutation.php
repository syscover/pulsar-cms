<?php namespace Syscover\Cms\GraphQL\Mutations;

use Carbon\Carbon;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Log;
use Syscover\Admin\Services\AttachmentService;
use Syscover\Core\Services\SQLService;
use Syscover\Cms\Models\Tag;
use Syscover\Cms\Models\Article;

class ArticleMutation extends Mutation
{
    public function type()
    {
        return GraphQL::type('CmsArticle');
    }

    public function args()
    {
        return [
            'object' => [
                'name' => 'object',
                'type' => Type::nonNull(GraphQL::type('CmsArticleInput'))
            ],
        ];
    }

    public static function setCategories($object, $args)
    {
        $object->categories()->sync($args['object']['categories_id']);
    }

    public static function setTags($object, $args, $destroyPreviousTags = false)
    {
        if($destroyPreviousTags && $object->tags->count() > 0)
        {
            Tag::whereIn('id', $object->tags->pluck('id'))
                ->delete();
        }

        if(is_array($args['object']['tags']) && count($args['object']['tags']) > 0)
        {
            $tags = [];
            foreach (array_unique($args['object']['tags']) as $tag)
            {
                $tags[] = new Tag([
                    'lang_id'   => $args['object']['lang_id'],
                    'name'      => $tag
                ]);
            }
            $object->tags()->saveMany($tags);
        }
    }
}

class AddArticleMutation extends ArticleMutation
{
    protected $attributes = [
        'name' => 'addArticle',
        'description' => 'Add new article'
    ];

    public function resolve($root, $args)
    {
        // check if there is id
        if(empty($args['object']['id']))
        {
            $id = Article::max('id');
            $id++;
        }
        else
        {
            $id = $args['object']['id'];
        }

        // set values to transform
        $args['object']['id'] = $id;
        $args['object']['publish'] = empty($args['object']['publish'])? null : (new Carbon($args['object']['publish'], config('app.timezone')))->toDateTimeString();
        $args['object']['date'] = empty($args['object']['date'])? null : (new Carbon($args['object']['date'], config('app.timezone')))->toDateTimeString();
        $args['object']['data_lang'] = Article::addLangDataRecord($args['object']['lang_id'], $id);

        // get custom fields
        if(isset($args['object']['field_group_id'])) $args['object']['data']['customFields'] = $args['object']['customFields'];

        // create new object
        $object = Article::create($args['object']);

        // get object with builder, to get every relations
        $object = Article::builder()
            ->where('cms_article.id', $object->id)
            ->where('cms_article.lang_id', $object->lang_id)
            ->first();

        // parse html and manage img of wysiwyg
        $html = AttachmentService::manageWysiwygAttachment($object->article, 'storage/app/public/cms/articles', 'storage/cms/articles', $object->id);
        if($html != null)
        {
            $object->article = $html;
            $object->save();
        }

        $this->setTags($object, $args, false);
        $this->setCategories($object, $args);

        // set attachments
        if(is_array($args['object']['attachments']))
        {
            // first save libraries to get id
            $attachments = AttachmentService::storeAttachmentsLibrary($args['object']['attachments']);

            // then save attachments
            AttachmentService::storeAttachments($attachments, 'storage/app/public/cms/articles', 'storage/cms/articles', Article::class, $object->id,  $object->lang_id);
        }

        return $object;
    }
}

class UpdateArticleMutation extends ArticleMutation
{
    protected $attributes = [
        'name' => 'updateArticle',
        'description' => 'Update article'
    ];

    public function resolve($root, $args)
    {
        // get custom fields
        $data = [];
        if(isset($args['object']['field_group_id'])) $data['customFields'] = $args['object']['customFields'];

        Article::where('id', $args['object']['id'])->where('lang_id', $args['object']['lang_id'])->update([
            'name'                  => $args['object']['name'],
            'parent_article_id'     => $args['object']['parent_article_id'],
            'author_id'             => $args['object']['author_id'],
            'section_id'            => $args['object']['section_id'],
            'family_id'             => $args['object']['family_id'],
            'status_id'             => $args['object']['status_id'],
            'publish'               => empty($args['object']['publish'])? null : (new Carbon($args['object']['publish'], config('app.timezone')))->toDateTimeString(),
            'date'                  => empty($args['object']['date'])? null : (new Carbon($args['object']['date'], config('app.timezone')))->toDateTimeString(),
            'title'                 => $args['object']['title'],
            'slug'                  => $args['object']['slug'],
            'link'                  => $args['object']['link'],
            'blank'                 => $args['object']['blank'],
            'sort'                  => $args['object']['sort'],
            'article'               => $args['object']['article'],
            'data'                  => json_encode($data)
        ]);

        $object = Article::where('cms_article.id', $args['object']['id'])
            ->where('cms_article.lang_id', $args['object']['lang_id'])
            ->first();

        // parse html and manage img of wysiwyg
        $html = AttachmentService::manageWysiwygAttachment($object->article, 'storage/app/public/cms/articles', 'storage/cms/articles', $object->id);
        if($html != null)
        {
            $object->article = $html;
            $object->save();
        }

        $this->setTags($object, $args, true);
        $this->setCategories($object, $args);

        // set attachments
        if(is_array($args['object']['attachments']))
        {
            // first save libraries to get id
            $attachments = AttachmentService::storeAttachmentsLibrary($args['object']['attachments']);

            // then save attachments
            AttachmentService::updateAttachments($attachments, 'storage/app/public/cms/articles', 'storage/cms/articles', Article::class, $object->id,  $object->lang_id);
        }

        return $object;
    }
}

class DeleteArticleMutation extends ArticleMutation
{
    protected $attributes = [
        'name' => 'deleteArticle',
        'description' => 'Delete article'
    ];

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::string())
            ],
            'lang' => [
                'name' => 'lang',
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        // destroy object
        $object = SQLService::destroyRecord($args['id'], Article::class, $args['lang']);

        // detach categories only if delete base land object
        if(base_lang() === $object->lang_id) $object->categories()->detach();

        // delete and detach tags
        Tag::whereIn('id', $object->tags->pluck('id'))->delete();
        $object->tags()->detach();

        // destroy attachments
        AttachmentService::deleteAttachments($args['id'], Article::class, $args['lang']);

        return $object;
    }
}
