<?php namespace Syscover\Cms\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class ArticleInput extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ArticleInput',
        'description'   => 'Article that user can to do in application.'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The id of article'
            ],
            'lang_id' => [
                'type' => Type::nonNull(Type::id()),
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
                'type' => Type::id(),
                'description' => 'The author of article'
            ],
            'section_id' => [
                'type' => Type::id(),
                'description' => 'The section of article to set your position in website'
            ],
            'family_id' => [
                'type' => Type::id(),
                'description' => 'The family of article to set our morphology'
            ],
            'status_id' => [
                'type' => Type::id(),
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
            'data_lang' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'JSON string that contain information about object translations'
            ]
        ];
    }
}