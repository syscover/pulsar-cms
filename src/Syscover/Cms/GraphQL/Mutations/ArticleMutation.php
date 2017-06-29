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
            'article' => [
                'name' => 'article',
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
        $args['article']['data_lang'] = Article::addLangDataRecord($args['article']['lang_id'], $args['article']['id']);

        return Article::create($args['article']);
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
        Article::where('id', $args['article']['id'])
            ->where('lang_id', $args['article']['lang_id'])
            ->update($args['article']);

        return Article::find($args['article']['id']);
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
