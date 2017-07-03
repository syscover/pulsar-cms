<?php namespace Syscover\Cms\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
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
        'name'          => 'addArticle',
        'description'   => 'Add new article'
    ];

    public function resolve($root, $args)
    {
        $args['object']['data_lang'] = Article::addLangDataRecord($args['object']['lang_id'], $args['object']['id']);

        return Article::create($args['object']);
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
        Article::where('id', $args['object']['id'])
            ->where('lang_id', $args['object']['lang_id'])
            ->update($args['object']);

        return Article::find($args['object']['id']);
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
