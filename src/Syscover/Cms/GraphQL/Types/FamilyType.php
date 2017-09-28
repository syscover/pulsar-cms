<?php namespace Syscover\Cms\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Syscover\Core\GraphQL\ScalarTypes\ObjectType;

class FamilyType extends GraphQLType {

    protected $attributes = [
        'name'          => 'Family',
        'description'   => 'Family that user can to do in application'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of family'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of family'
            ],
            'excerpt_editor_id' => [
                'type' => Type::int(),
                'description' => 'Activate excerpt editor'
            ],
            'article_editor_id' => [
                'type' => Type::int(),
                'description' => 'Activate article editor'
            ],
            'field_group_id' => [
                'type' => Type::int(),
                'description' => 'Activate custom fields in article'
            ],
            'date' => [
                'type' => Type::boolean(),
                'description' => 'Activate date in article'
            ],
            'title' => [
                'type' => Type::boolean(),
                'description' => 'Activate title in article'
            ],
            'slug' => [
                'type' => Type::boolean(),
                'description' => 'Activate slug in article'
            ],
            'link' => [
                'type' => Type::boolean(),
                'description' => 'Activate link in article'
            ],
            'categories' => [
                'type' => Type::boolean(),
                'description' => 'Activate categories in article'
            ],
            'sort' => [
                'type' => Type::boolean(),
                'description' => 'Activate sort in article'
            ],
            'tags' => [
                'type' => Type::boolean(),
                'description' => 'Activate tags in article'
            ],
            'article_parent' => [
                'type' => Type::boolean(),
                'description' => 'Activate article parent in article'
            ],
            'attachments' => [
                'type' => Type::boolean(),
                'description' => 'Activate attachments in article'
            ],
            'attachment_families' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'Attachments families that can to be attachment'
            ],
            'data' => [
                'type' => app(ObjectType::class),
                'description' => 'Data to include content extra'
            ]
        ];
    }
}