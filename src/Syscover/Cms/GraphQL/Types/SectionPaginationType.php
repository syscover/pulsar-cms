<?php namespace Syscover\Cms\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Syscover\Core\Services\SQLService;

class SectionPaginationType extends GraphQLType
{
    // to documentation
    protected $attributes = [
        'name'          => 'SectionPaginationType',
        'description'   => 'Pagination for section objects.'
    ];

    public function fields()
    {
        return [
            'total' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The total records'
            ],
            'filtered' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'N records filtered'
            ],
            'sections' => [
                'type' => Type::listOf(GraphQL::type('CmsSection')),
                'description' => 'List of families filtered',
                'args' => [
                    'sql' => [
                        'type' => Type::listOf(GraphQL::type('CoreSQLQueryInput')),
                        'description' => 'Field to add SQL operations'
                    ]
                ]
            ]
        ];
    }

    public function resolveSectionsField($root, $args)
    {
        // get query ordered and limited
        $query = SQLService::getQueryOrderedAndLimited($root->query, $args['sql']);

        // get objects filtered
        $objects = $query->get();

        return $objects;
    }
}