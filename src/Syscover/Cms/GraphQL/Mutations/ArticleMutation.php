<?php namespace Syscover\Cms\GraphQL\Mutations;

use Carbon\Carbon;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Admin\Models\Field;
use Syscover\Admin\Services\AttachmentService;
use Syscover\Core\Services\SQLService;
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
}

class AddArticleMutation extends ArticleMutation
{
    protected $attributes = [
        'name' => 'addArticle',
        'description' => 'Add new article'
    ];

    public function resolve($root, $args)
    {
        // get custom fields
        $data = [];
        if(isset($args['object']['field_group_id']))
        {
            $fields = Field::where('field_group_id', $args['object']['field_group_id'])->get();
            foreach ($fields as $field)
            {
                $data['properties'][$field->name] = $args['object']['customFields'][$field->name];
            }
        }

        // check if there is id
        if($args['object']['id'])
        {
            $id = $args['object']['id'];
        }
        else
        {
            $id = Article::max('id');
            $id++;
        }

        // set values to transform
        $args['object']['id'] = $id;
        $args['object']['publish'] = empty($args['object']['publish'])? null : (new Carbon($args['object']['publish'], config('app.timezone')))->toDateTimeString();
        $args['object']['date'] = empty($args['object']['date'])? null : (new Carbon($args['object']['date'], config('app.timezone')))->toDateTimeString();
        $args['object']['data_lang'] = Article::addLangDataRecord($args['object']['lang_id'], $id);
        $args['object']['data'] = $data;

        // create new object
        $object = Article::create($args['object']);

        // get object with builder, to get every relations
        $object = Article::builder()->where('id', $object->id)->where('lang_id', $object->lang_id)->first();

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
        if(isset($args['object']['field_group_id']))
        {
            $fields = Field::where('field_group_id', $args['object']['field_group_id'])->get();
            foreach ($fields as $field)
            {
                $data['properties'][$field->name] = $args['object'][$field->name];
            }
        }

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

        $object = Article::where('id', $args['object']['id'])
            ->where('lang_id', $args['object']['lang_id'])
            ->first();

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
        $object = SQLService::destroyRecord($args['id'], Article::class, $args['lang']);

        return $object;
    }
}
