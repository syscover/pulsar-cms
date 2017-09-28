<?php namespace Syscover\Cms\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class SectionInput extends GraphQLType
{
    protected $attributes = [
        'name'          => 'SectionInput',
        'description'   => 'Section of webpage to implement in cms'
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of section'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of section'
            ],
            'family_id' => [
                'type' => Type::int(),
                'description' => 'Article family who belong this section'
            ],
            'attachment_families' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'Attachments families that can to be attachment'
            ],
        ];
    }
}