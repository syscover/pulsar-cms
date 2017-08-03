<?php namespace Syscover\Cms\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Syscover\Core\GraphQL\ScalarTypes\AnyType;

class TagType extends GraphQLType {

    protected $attributes = [
        'name'          => 'Tag',
        'description'   => 'Tag that you can add to article'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(app(AnyType::class)),
                'description' => 'The id of category'
            ],
            'lang_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'lang of category'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of category'
            ]
        ];
    }

    public function interfaces() {
        return [GraphQL::type('CoreObjectInterface')];
    }
}