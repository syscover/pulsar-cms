<?php namespace Syscover\Cms\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Syscover\Core\GraphQL\ScalarTypes\ObjectType;

class ArticleInput extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ArticleInput',
        'description'   => 'Article that user can to do in application'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
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
                'type' => Type::string(),
                'description' => 'The author of article'
            ],
            'section_id' => [
                'type' => Type::string(),
                'description' => 'The section of article to set your position in website'
            ],
            'family_id' => [
                'type' => Type::int(),
                'description' => 'The family of article to set our morphology'
            ],
            'field_group_id' => [
                'type' => Type::int(),
                'description' => 'The file group that has this article'
            ],
            'status_id' => [
                'type' => Type::int(),
                'description' => 'The status of article, you can publish or draft your article'
            ],
            'categories_id' => [
                'type' => Type::listOf(Type::int()),
                'description' => 'Id categories'
            ],
            'tags' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'Id tags'
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
            'article' => [
                'type' => Type::string(),
                'description' => 'Article'
            ],
            'attachments' => [
                'type' => Type::listOf(app(ObjectType::class)),
                'description' => 'List of attachments added to article'
            ],
            'customFields' => [
                'type' => app(ObjectType::class),
                'description' => 'Properties from custom fields'
            ],
            'data_lang' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'JSON string that contain information about object translations'
            ]
        ];
    }
}