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

        // SECTION
        GraphQL::addType(\Syscover\Cms\GraphQL\Types\SectionPaginationType::class, 'CmsSectionPagination');
        GraphQL::addType(\Syscover\Cms\GraphQL\Types\SectionType::class, 'CmsSection');
        GraphQL::addType(\Syscover\Cms\GraphQL\Inputs\SectionInput::class, 'CmsSectionInput');

    }

    public static function bootGraphQLSchema()
    {
        GraphQL::addSchema('default', array_merge_recursive(GraphQL::getSchemas()['default'], [
            'query' => [
                // FAMILY
                'cmsFamiliesPagination'     => \Syscover\Cms\GraphQL\Queries\FamiliesPaginationQuery::class,
                'cmsFamilies'               => \Syscover\Cms\GraphQL\Queries\FamiliesQuery::class,
                'cmsFamily'                 => \Syscover\Cms\GraphQL\Queries\FamilyQuery::class,

                // SECTION
                'cmsSectionsPagination'     => \Syscover\Cms\GraphQL\Queries\SectionsPaginationQuery::class,
                'cmsSections'               => \Syscover\Cms\GraphQL\Queries\SectionsQuery::class,
                'cmsSection'                => \Syscover\Cms\GraphQL\Queries\SectionQuery::class,
            ],
            'mutation' => [
                // FAMILY
                'cmsAddFamily'              => \Syscover\Cms\GraphQL\Mutations\AddFamilyMutation::class,
                'cmsUpdateFamily'           => \Syscover\Cms\GraphQL\Mutations\UpdateFamilyMutation::class,
                'cmsDeleteFamily'           => \Syscover\Cms\GraphQL\Mutations\DeleteFamilyMutation::class,

                // SECTION
                'cmsAddSection'             => \Syscover\Cms\GraphQL\Mutations\AddSectionMutation::class,
                'cmsUpdateSection'          => \Syscover\Cms\GraphQL\Mutations\UpdateSectionMutation::class,
                'cmsDeleteSection'          => \Syscover\Cms\GraphQL\Mutations\DeleteSectionMutation::class,
            ]
        ]));
    }
}