<?php namespace Syscover\Cms\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CategoryInput extends GraphQLType
{
    protected $attributes = [
        'name'          => 'CategoryInput',
        'description'   => 'Category that user can to do in application.'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::id(),
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