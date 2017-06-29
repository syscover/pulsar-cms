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

        // CATEGORY
        GraphQL::addType(\Syscover\Cms\GraphQL\Types\CategoryPaginationType::class, 'CmsCategoryPagination');
        GraphQL::addType(\Syscover\Cms\GraphQL\Types\CategoryType::class, 'CmsCategory');
        GraphQL::addType(\Syscover\Cms\GraphQL\Inputs\CategoryInput::class, 'CmsCategoryInput');

        // ARTICLE
        GraphQL::addType(\Syscover\Cms\GraphQL\Types\ArticlePaginationType::class, 'CmsArticlePagination');
        GraphQL::addType(\Syscover\Cms\GraphQL\Types\ArticleType::class, 'CmsArticle');
        GraphQL::addType(\Syscover\Cms\GraphQL\Inputs\ArticleInput::class, 'CmsArticleInput');
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

                // CATEGORY
                'cmsCategoriesPagination'   => \Syscover\Cms\GraphQL\Queries\CategoriesPaginationQuery::class,
                'cmsCategories'             => \Syscover\Cms\GraphQL\Queries\CategoriesQuery::class,
                'cmsCategory'               => \Syscover\Cms\GraphQL\Queries\CategoryQuery::class,

                // ARTICLE
                'cmsArticlesPagination'     => \Syscover\Cms\GraphQL\Queries\ArticlesPaginationQuery::class,
                'cmsArticles'               => \Syscover\Cms\GraphQL\Queries\ArticlesQuery::class,
                'cmsArticle'                => \Syscover\Cms\GraphQL\Queries\ArticleQuery::class,
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

                // CATEGORY
                'cmsAddCategory'            => \Syscover\Cms\GraphQL\Mutations\AddCategoryMutation::class,
                'cmsUpdateCategory'         => \Syscover\Cms\GraphQL\Mutations\UpdateCategoryMutation::class,
                'cmsDeleteCategory'         => \Syscover\Cms\GraphQL\Mutations\DeleteCategoryMutation::class,

                // ARTICLE
                'cmsAddArticle'             => \Syscover\Cms\GraphQL\Mutations\AddArticleMutation::class,
                'cmsUpdateArticle'          => \Syscover\Cms\GraphQL\Mutations\UpdateArticleMutation::class,
                'cmsDeleteArticle'          => \Syscover\Cms\GraphQL\Mutations\DeleteArticleMutation::class,
            ]
        ]));
    }
}