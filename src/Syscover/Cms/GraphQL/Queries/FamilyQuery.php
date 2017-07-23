<?php namespace Syscover\Cms\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use Syscover\Core\Services\SQLService;
use Syscover\Cms\Models\Family;

class FamilyQuery extends Query
{
    protected $attributes = [
        'name'          => 'FamilyQuery',
        'description'   => 'Query to get families'
    ];

    public function type()
    {
        return GraphQL::type('CmsFamily');
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
        $query = SQLService::getQueryFiltered(Family::builder(), $args['sql']);

        return $query->first();
    }
}