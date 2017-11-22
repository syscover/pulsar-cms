<?php namespace Syscover\Cms\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType {

    protected $attributes = [
        'name'          => 'Category',
        'description'   => 'Category that user can to do in application'
    ];

    public function fields()
    {
        return [
            'ix' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The index of category'
            ],
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of category'
            ],
            'lang_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'lang of category'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of category'
            ],
            'slug' => [
                'type' => Type::string(),
                'description' => 'The name of category'
            ],
            'section_id' => [
                'type' => Type::string(),
                'description' => 'The section of category to set your position in website'
            ],
            'section' => [
                'type' => GraphQL::type('CmsSection'),
                'description' => 'Section object'
            ],
            'sort' => [
                'type' => Type::int(),
                'description' => 'Activate sort in article'
            ],
            'data_lang' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'JSON string that contain information about object translations'
            ]
        ];
    }
}