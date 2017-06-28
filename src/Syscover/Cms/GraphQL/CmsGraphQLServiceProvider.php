<?php namespace Syscover\Cms\GraphQL;

use GraphQL;

class CmsGraphQLServiceProvider
{
    public static function bootGraphQLTypes()
    {
        // FAMILY
        GraphQL::addType(\Syscover\Cms\GraphQL\Types\FamilyPaginationType::class, 'CmsFamilyPagination');
        GraphQL::addType(\Syscover\Cms\GraphQL\Types\FamilyType::class, 'CmsFamily');
        GraphQL::addType(\Syscover\Cms\GraphQL\Inputs\FamilyInput::class, 'CmsFamilyInput');
    }

    public static function bootGraphQLSchema()
    {
        GraphQL::addSchema('default', array_merge_recursive(GraphQL::getSchemas()['default'], [
            'query' => [
                // FAMILY
                'cmsFamiliesPagination'     => \Syscover\Cms\GraphQL\Queries\FamiliesPaginationQuery::class,
                'cmsFamilies'               => \Syscover\Cms\GraphQL\Queries\FamiliesQuery::class,
                'cmsFamily'                 => \Syscover\Cms\GraphQL\Queries\FamilyQuery::class,
            ],
            'mutation' => [
                // FAMILY
//                'cmsAddFamily'              => \Syscover\Cms\GraphQL\Mutations\AddFamilyMutation::class,
//                'cmsUpdateFamily'           => \Syscover\Cms\GraphQL\Mutations\UpdateFamilyMutation::class,
//                'cmsDeleteFamily'           => \Syscover\Cms\GraphQL\Mutations\DeleteFamilyMutation::class,
            ]
        ]));
    }
}