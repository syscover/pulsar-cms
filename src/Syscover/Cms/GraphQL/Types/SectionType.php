<?php namespace Syscover\Cms\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class SectionType extends GraphQLType {

    protected $attributes = [
        'name'          => 'Section',
        'description'   => 'Section of web page to implement in cms'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of section'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of section'
            ],
            'article_family_id' => [
                'type' => Type::int(),
                'description' => 'Article family who belong this section'
            ],
            'family' => [
                'type' => GraphQL::type('CmsFamily'),
                'description' => 'Family of section'
            ]
        ];
    }
}