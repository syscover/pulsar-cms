<?php namespace Syscover\Cms\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Core\Services\SQLService;
use Syscover\Cms\Models\Article;

class ArticleQuery extends Query
{
    protected $attributes = [
        'name'          => 'ArticleQuery',
        'description'   => 'Query to get a article'
    ];

    public function type()
    {
        return GraphQL::type('CmsArticle');
    }

    public function args()
    {
        return [
            'sql' => [
                'name'          => 'sql',
                'type'          => Type::listOf(GraphQL::type('CoreSQLQueryInput')),
                'description'   => 'Field to add SQL operations'
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $query = SQLService::getQueryFiltered(Article::builder(), $args['sql']);
        $object = $query->first();
        $object->load('attachments');

        return $object;
    }
}