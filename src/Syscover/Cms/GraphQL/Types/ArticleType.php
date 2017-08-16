<?php namespace Syscover\Cms\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Syscover\Core\GraphQL\ScalarTypes\ObjectType;

class ArticleType extends GraphQLType {

    protected $attributes = [
        'name'          => 'Article',
        'description'   => 'Article that user can to do in application'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of article'
            ],
            'lang_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'lang of article'
            ],
            'parent_article_id' => [
                'type' => Type::int(),
                'description' => 'parent id article to relation a article with other'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of article'
            ],
            'author_id' => [
                'type' => Type::int(),
                'description' => 'The author of article'
            ],
            'section_id' => [
                'type' => Type::string(),
                'description' => 'The section of article to set your position in website'
            ],
            'section' => [
                'type' => GraphQL::type('CmsSection'),
                'description' => 'Section object'
            ],
            'family_id' => [
                'type' => Type::int(),
                'description' => 'The family of article to set our morphology'
            ],
            'status_id' => [
                'type' => Type::int(),
                'description' => 'The status of article, you can publish or draft your article'
            ],
            'publish' => [
                'type' => Type::string(),
                'description' => 'Set the date to publish your article'
            ],
            'date' => [
                'type' => Type::string(),
                'description' => 'Date when this article gone created'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'Title of article'
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'Final section of the url to access the article'
            ],
            'categories' => [
                'type' => Type::listOf(GraphQL::type('CmsCategory')),
                'description' => 'Categories'
            ],
            'link' => [
                'type' => Type::string(),
                'description' => 'Link to add in article'
            ],
            'blank' => [
                'type' => Type::boolean(),
                'description' => 'Set article to open in new window'
            ],
            'sort' => [
                'type' => Type::int(),
                'description' => 'Sort the article'
            ],
            'tags' => [
                'type' => Type::listOf(GraphQL::type('CmsTag')),
                'description' => 'Tags of article'
            ],
            'excerpt' => [
                'type' => Type::string(),
                'description' => 'Article'
            ],
            'article' => [
                'type' => Type::string(),
                'description' => 'Article'
            ],
            'data_lang' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'JSON string that contain information about object translations'
            ],
            'data' => [
                'type' => app(ObjectType::class),
                'description' => 'JSON string that contain information about object translations'
            ],
            'attachments' => [
                'type' => Type::listOf(GraphQL::type('AdminAttachment')),
                'description' => 'List of attachments that has this article'
            ]
        ];
    }

    public function resolveCategoriesField($object, $args)
    {
        return $object->categories->where('lang_id', $object->lang_id);
    }
}