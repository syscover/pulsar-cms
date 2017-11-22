<?php namespace Syscover\Cms\GraphQL\Mutations;

use Carbon\Carbon;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use Syscover\Admin\Services\AttachmentService;
use Syscover\Cms\Services\ArticleService;
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
}

class AddArticleMutation extends ArticleMutation
{
    protected $attributes = [
        'name' => 'addArticle',
        'description' => 'Add new article'
    ];

    public function resolve($root, $args)
    {
        return ArticleService::create($args['object']);
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
        return ArticleService::update($args['object']);
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
                'type' => Type::nonNull(Type::int())
            ],
            'lang_id' => [
                'name' => 'lang_id',
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        // destroy object
        $object = SQLService::destroyRecord($args['id'], Article::class, $args['lang_id']);

        // detach categories only if delete base land object
        if(base_lang() === $object->lang_id) $object->categories()->detach();

        // delete and detach tags
        Tag::whereIn('id', $object->tags->pluck('id'))->delete();
        $object->tags()->detach();

        // destroy attachments
        AttachmentService::deleteAttachments($args['id'], Article::class, $args['lang_id']);

        return $object;
    }
}
