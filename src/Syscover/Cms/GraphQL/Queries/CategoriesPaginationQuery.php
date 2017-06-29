<?php namespace Syscover\Cms\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Core\Services\SQLService;
use Syscover\Cms\Models\Category;

class CategoriesPaginationQuery extends Query
{
    protected $attributes = [
        'name'          => 'CategoriesPaginationQuery',
        'description'   => 'Query to get families list'
    ];

    public function type()
    {
        return GraphQL::type('CmsCategoryPagination');
    }

    public function args()
    {
        return [
            'lang' => [
                'name'          => 'lang',
                'type'          => Type::string(),
                'description'   => 'to filter by lang'
            ],
            'sql' => [
                'name'          => 'sql',
                'type'          => Type::listOf(GraphQL::type('CoreSQLQueryInput')),
                'description'   => 'Field to add SQL operations'
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $query = SQLService::getQueryFiltered(Category::builder(), $args['sql'], $args['lang']);

        // count records filtered
        $filtered = $query->count();

        // N total records
        $total = SQLService::countPaginateTotalRecords(Category::builder(), $args['lang']);

        return (Object) [
            'total'     => $total,
            'filtered'  => $filtered,
            'query'     => $query
        ];
    }
}