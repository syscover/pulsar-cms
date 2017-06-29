<?php namespace Syscover\Cms\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Syscover\Cms\GraphQL\Types\SectionType;

class SectionInput extends SectionType
{
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
            'article_family_id' => [
                'type' => Type::int(),
                'description' => 'Article family who belong this section'
            ]
        ];
    }
}